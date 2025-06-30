<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $technician = $request->query('technician');
        $vehicle_type = $request->query('vehicle_type');
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        $query = ServiceBooking::with(['customer.user','vehicle.vehicleType','technician.user','serviceDetails'])->latest();
        
        if ($status) {
            $query->where('status', $status);
        }
        if ($technician) {
            $query->where('technician_id', $technician);
        }
        if ($vehicle_type) {
            $query->whereHas('vehicle', function($q) use ($vehicle_type) {
                $q->where('vehicle_type_id', $vehicle_type);
            });
        }
        if ($start_date) {
            $query->whereDate('created_at', '>=', $start_date);
        }
        if ($end_date) {
            $query->whereDate('created_at', '<=', $end_date);
        }

        $bookings = $query->paginate(20);

        $statusOptions = [
            '' => 'All Status',
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled'
        ];

        $technicians = \App\Models\Technician::with('user')->get();
        $vehicleTypes = collect();

        return view('admin.bookings.index', compact('bookings','status','technician','start_date','end_date', 'statusOptions', 'technicians'));
    }

    public function show(ServiceBooking $booking)
    {
        $booking->load(['customer.user','vehicle.vehicleType','technician.user','serviceDetails']);
        $spareParts = \App\Models\SparePart::all();
        $sparePartsMap = $spareParts->pluck('price','id');
        $detailsForJs = $booking->serviceDetails->map(function($d){
            return [
                'type' => $d->type==='part' ? 'part' : 'service',
                'description' => $d->description,
                'spare_part_id' => $d->spare_part_id,
                'quantity' => $d->quantity,
                'unit_price' => $d->unit_price,
            ];
        });
        // add default row if none
        if($detailsForJs->isEmpty()){
            $detailsForJs->push([
                'type' => 'service',
                'description' => $booking->serviceCategory?->name ?? '',
                'spare_part_id' => null,
                'quantity' => 1,
                'unit_price' => $booking->serviceCategory?->price ?? 0,
            ]);
        }
        return view('admin.bookings.show', compact('booking','spareParts','sparePartsMap','detailsForJs'));
    }

    public function setAmountAndComplete(Request $request, ServiceBooking $booking)
    {
        $data = $request->validate([
            'estimated_cost' => ['required','numeric','min:0']
        ]);

        // if previously not completed, deduct stock
        $wasCompleted = $booking->status === 'completed';
        $booking->update([
            'estimated_cost' => $data['estimated_cost'],
            'status' => 'completed'
        ]);
        if(!$wasCompleted){
            foreach($booking->spareParts as $detail){
                if($detail->sparePart){
                    $detail->sparePart->decrement('stock_quantity', $detail->quantity);
                }
            }
        }

        // notify customer whatsapp
        if($booking->customer && $booking->customer->user && $booking->customer->user->phone){
            $booking->customer->user->notify(new \App\Notifications\ServiceCompletedPaymentDue($booking));
        }

        return back()->with('success','Amount set and booking marked completed');
    }

    public function assignTechnician(Request $request, ServiceBooking $booking)
    {
        $data = $request->validate([
            'technician_id' => ['required','exists:technicians,id']
        ]);
        $booking->update(['technician_id' => $data['technician_id']]);
        return back()->with('success','Technician assigned');
    }

    // saveDetails method added below

    public function saveDetails(Request $request, ServiceBooking $booking)
    {
        $data = $request->validate([
            'items' => ['required','array'],
            'items.*.type' => ['required','in:service,part'],
            'items.*.description' => ['nullable','string','max:100'],
            'items.*.spare_part_id' => ['nullable','exists:spare_parts,id'],
            'items.*.quantity' => ['required','integer','min:1'],
            'items.*.unit_price' => ['required','numeric','min:0']
        ]);

        // Delete old details
        $booking->serviceDetails()->delete();
        $total = 0;
        foreach($data['items'] as $item){
            $subtotal = $item['unit_price'] * $item['quantity'];
            $detail = new \App\Models\ServiceDetail();
            $detail->booking_id = $booking->id;
            $detail->type = $item['type'] === 'part' ? 'part' : 'labor';
            $detail->spare_part_id = $item['type']==='part' ? $item['spare_part_id'] : null;
            $detail->description = $item['type']==='part' ? (\App\Models\SparePart::find($item['spare_part_id'])->name ?? 'Part') : ($item['description'] ?? 'Service');
            $detail->quantity = $item['quantity'];
            $detail->unit_price = $item['unit_price'];
            $detail->total_price = $subtotal;
            $detail->save();
            $total += $subtotal;

            // deduct stock for parts
            if($detail->type==='part' && $detail->sparePart){
                $detail->sparePart->decrement('stock_quantity',$detail->quantity);
            }
        }

        // update cost & status
        $booking->update([
            'estimated_cost' => $total,
        ]);

        // notify customer
        if($booking->customer && $booking->customer->user && $booking->customer->user->phone){
            $booking->customer->user->notify(new \App\Notifications\ServiceCompletedPaymentDue($booking));
        }

        return back()->with('success','Details saved & customer notified');
    }

    public function export(Request $request)
    {
        $status = $request->query('status');
        $technician = $request->query('technician');
        $vehicle_type = $request->query('vehicle_type');
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        $bookings = ServiceBooking::with(['customer.user','vehicle','technician.user','serviceDetails'])->latest();
        
        if ($status) {
            $bookings->where('status', $status);
        }
        if ($technician) {
            $bookings->where('technician_id', $technician);
        }
        if ($vehicle_type) {
            $bookings->whereHas('vehicle', function($q) use ($vehicle_type) {
                $q->where('vehicle_type_id', $vehicle_type);
            });
        }
        if ($start_date) {
            $bookings->whereDate('created_at', '>=', $start_date);
        }
        if ($end_date) {
            $bookings->whereDate('created_at', '<=', $end_date);
        }

        $bookings = $bookings->get();

        // Generate Excel file
        $filename = 'bookings_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        );

        $columns = array(
            'ID', 'Customer', 'Vehicle', 'Technician', 'Status', 'Created At', 'Total Amount'
        );

        $callback = function() use($bookings, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($bookings as $booking) {
                $row = array(
                    $booking->id,
                    $booking->customer->user->name,
                    $booking->vehicle->license_plate . ' (' . $booking->vehicle->brand . ' ' . $booking->vehicle->model . ')',
                    $booking->technician ? $booking->technician->user->name : '',
                    $booking->status,
                    $booking->created_at->format('Y-m-d H:i:s'),
                    $booking->total_amount
                );
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
