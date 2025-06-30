<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceBooking;
use App\Models\Technician;
use App\Models\VehicleType;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Bulanan
        $currentMonth = Carbon::now()->format('Y-m');
        $bookingCount = ServiceBooking::count();
        $monthlyBookings = ServiceBooking::whereMonth('created_at', Carbon::now())->count();
        $monthlyRevenue = Payment::where('status','confirmed')
            ->whereMonth('created_at', Carbon::now())
            ->sum('amount');

        // Statistik Pembayaran 7 hari terakhir (status confirmed)
        $paymentStats = Payment::where('status', 'confirmed')
            ->whereDate('created_at', '>=', now()->subDays(6))
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapWithKeys(fn($row) => [$row->date => (float) $row->total]);

        // Statistik Teknisi
        $technicians = Technician::withCount([
            'serviceBookings as bookings_count' => function($query) {
                return $query->whereMonth('created_at', Carbon::now());
            },
            'serviceBookings as completed_bookings_count' => function($query) {
                return $query->whereMonth('updated_at', Carbon::now())
                            ->where('status', 'completed');
            }
        ])->get();

        // Statistik Kendaraan
        $vehicleStats = ServiceBooking::with(['vehicle.vehicleType'])
            ->whereMonth('created_at', Carbon::now())
            ->get()
            ->filter(function ($booking) {
                return $booking->vehicle && $booking->vehicle->vehicleType;
            })
            ->groupBy(function ($booking) {
                return $booking->vehicle->vehicle_type_id;
            })
            ->map(function ($group) {
                $vehicleTypeName = optional(optional($group->first()->vehicle)->vehicleType)->name ?? 'Unknown';
                return [
                    'vehicle_type' => $vehicleTypeName,
                    'count' => $group->count(),
                ];
            })
            ->values();

        
        // Top Spare Parts
        $topParts = DB::table('service_details')
            ->join('service_bookings','service_details.booking_id','=','service_bookings.id')
            ->join('spare_parts','service_details.spare_part_id','=','spare_parts.id')
            ->where('service_details.type','part')
            ->whereIn('service_bookings.status',['completed','awaiting_payment'])
            ->select('spare_parts.name', DB::raw('SUM(service_details.quantity) as qty'))
            ->groupBy('spare_parts.name')
            ->orderByDesc('qty')
            ->limit(5)
            ->get();

        // Top Services
        $topServices = DB::table('service_details')
            ->join('service_bookings','service_details.booking_id','=','service_bookings.id')
            ->where('service_details.type','labor')
            ->whereIn('service_bookings.status',['completed','awaiting_payment'])
            ->select('service_details.description', DB::raw('SUM(service_details.quantity) as qty'))
            ->groupBy('service_details.description')
            ->orderByDesc('qty')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'bookingCount',
            'monthlyBookings',
            'monthlyRevenue',
            'technicians',
            'vehicleStats',
            'currentMonth',
            'paymentStats',
            'topParts',
            'topServices'
        ));
    }
}

