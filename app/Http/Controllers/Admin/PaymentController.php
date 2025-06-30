<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        // Filter parameters
        $status = $request->query('status');
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');
        $min_amount = $request->query('min_amount');
        $max_amount = $request->query('max_amount');
        $booking_status = $request->query('booking_status');

        $query = Payment::with(['booking.customer.user'])->latest();
        
        // Apply filters
        if ($status) {
            $query->where('status', $status);
        }
        if ($start_date) {
            $query->whereDate('payment_date', '>=', $start_date);
        }
        if ($end_date) {
            $query->whereDate('payment_date', '<=', $end_date);
        }
        if ($min_amount) {
            $query->where('amount', '>=', $min_amount);
        }
        if ($max_amount) {
            $query->where('amount', '<=', $max_amount);
        }
        if ($booking_status) {
            $query->whereHas('booking', function($q) use ($booking_status) {
                $q->where('status', $booking_status);
            });
        }

        $payments = $query->paginate(20);

        // Get statistics
        $totalRevenue = Payment::where('status', 'confirmed')->sum('amount');
        $pendingPayments = Payment::where('status', 'pending')->count();
        $failedPayments = Payment::where('status', 'failed')->count();

        return view('admin.payments.index', compact(
            'payments',
            'status',
            'start_date',
            'end_date',
            'min_amount',
            'max_amount',
            'booking_status',
            'totalRevenue',
            'pendingPayments',
            'failedPayments'
        ));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:confirmed,failed',
            'note' => 'nullable|string',
            'payment_method' => 'nullable|string',
        ]);

        $updateData = [
            'status' => $validated['status'],
        ];
        if(isset($validated['note'])){
            $updateData['note'] = $validated['note'];
        }
        if(array_key_exists('payment_method', $validated)){
            $updateData['payment_method'] = $validated['payment_method'];
        }

        $payment->update($updateData);

        // Send notification if status changes
        if ($validated['status'] === 'confirmed') {
            $payment->booking->update(['payment_status' => 'paid']);
            // Send email notification to customer
            // Mail::to($payment->booking->customer->user->email)->send(new PaymentConfirmed($payment));
        }

        return back()->with('success', 'Payment updated successfully');
    }

    public function export(Request $request)
    {
        $payments = Payment::with(['booking.customer.user'])->latest();
        
        // Apply the same filters as in index
        if ($request->query('status')) {
            $payments->where('status', $request->query('status'));
        }
        if ($request->query('start_date')) {
            $payments->whereDate('payment_date', '>=', $request->query('start_date'));
        }
        if ($request->query('end_date')) {
            $payments->whereDate('payment_date', '<=', $request->query('end_date'));
        }
        if ($request->query('min_amount')) {
            $payments->where('amount', '>=', $request->query('min_amount'));
        }
        if ($request->query('max_amount')) {
            $payments->where('amount', '<=', $request->query('max_amount'));
        }
        if ($request->query('booking_status')) {
            $payments->whereHas('booking', function($q) use ($request) {
                $q->where('status', $request->query('booking_status'));
            });
        }

        $payments = $payments->get();

        // Generate Excel file
        $filename = 'payments_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        );

        $columns = array(
            'ID', 'Payment Date', 'Booking Code', 'Customer', 'Amount', 'Status', 'Payment Method', 'Note', 'Created At'
        );

        $callback = function() use($payments, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($payments as $payment) {
                $row = array(
                    $payment->id,
                    $payment->payment_date ? $payment->payment_date->format('Y-m-d') : '',
                    $payment->booking->booking_code,
                    $payment->booking->customer->user->name,
                    'Rp ' . number_format($payment->amount, 0, ',', '.'),
                    ucfirst($payment->status),
                    $payment->payment_method,
                    $payment->note,
                    $payment->created_at->format('Y-m-d H:i:s')
                );
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
