<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $customer = $user->customer;

        // Jika tidak ada data customer, kembalikan view dengan nilai default
        if (!$customer) {
            return view('customer.dashboard', [
                'vehiclesCount' => 0,
                'activeBookings' => 0,
                'lastServiceDate' => null,
                'recentBookings' => [],
            ]);
        }

        $vehiclesCount = $customer->vehicles()->count();

        // Menggunakan 'serviceBookings' sesuai kode Anda
        $activeBookings = $customer->serviceBookings()->where('status', '!=', 'paid')->count();

        // --- PERUBAHAN DI SINI ---
        // Mencari servis terakhir yang statusnya 'completed' ATAU 'paid'
        $lastService = $customer->serviceBookings()
                                ->whereIn('status', ['completed', 'paid'])
                                ->latest('booking_date')
                                ->first();
                                
        // Format tanggal agar sesuai dengan yang diharapkan oleh view
        $lastServiceDate = $lastService ? $lastService->booking_date->format('d M Y') : null;

        // Mengambil 5 booking terbaru untuk ditampilkan di daftar aktivitas
        $recentBookings = $customer->serviceBookings()
                                ->with(['serviceCategory', 'vehicle']) // Eager load untuk performa lebih baik
                                ->latest('booking_date') // Urutkan berdasarkan yang terbaru
                                ->take(5) // Ambil 5 data saja
                                ->get();

        // Kirim semua data yang dibutuhkan ke view, termasuk $recentBookings
        return view('customer.dashboard', compact(
            'vehiclesCount', 
            'activeBookings', 
            'lastServiceDate', 
            'recentBookings' // <-- Variabel yang dibutuhkan sekarang sudah dikirim
        ));
    }
}
