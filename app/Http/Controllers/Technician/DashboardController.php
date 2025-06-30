<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\ServiceBooking;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $tech = auth()->user()->technician;
        if (!$tech) {
            return redirect()->route('dashboard')->with('error', 'Technician profile not found.');
        }

        $today = today(); // Menggunakan helper Carbon untuk hari ini

        // --- Statistik untuk Kartu ---
        // Menggunakan relasi untuk query yang lebih bersih
        $todayJobs = $tech->serviceBookings()->whereDate('booking_date', $today)->count();
        $pending = $tech->serviceBookings()->where('status', 'pending')->count();
        $inProgress = $tech->serviceBookings()->where('status', 'in_progress')->count();
        
        // Menghitung pekerjaan yang selesai HARI INI saja
        $completed = $tech->serviceBookings()->where('status', 'completed')->whereDate('updated_at', $today)->count();
        
        // --- Daftar Pekerjaan Aktif untuk Tabel ---
        // Mengambil semua pekerjaan yang statusnya pending atau in_progress
        $myActiveJobs = $tech->serviceBookings()
                             ->whereIn('status', ['pending', 'in_progress'])
                             ->with(['serviceCategory', 'vehicle', 'customer.user']) // Eager load untuk performa
                             ->orderBy('booking_date', 'asc')
                             ->get();

        // Kirim semua variabel yang dibutuhkan ke view
        return view('technician.dashboard', compact(
            'todayJobs',
            'pending',
            'inProgress',
            'completed',
            'myActiveJobs' // <-- Variabel baru ditambahkan
        ));
    }
}
