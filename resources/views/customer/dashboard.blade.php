<x-customer-layout>
    <div class="space-y-8">
        {{-- Bagian Header Selamat Datang --}}
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ auth()->user()->name }}!</h1>
            <p class="mt-1 text-gray-600">Berikut adalah ringkasan aktivitas dan kendaraan Anda.</p>
        </div>

        {{-- Kartu Statistik dengan warna solid untuk memastikan visibilitas --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Total Vehicles -->
            {{-- Menggunakan inline style untuk memastikan warna tampil --}}
            <a href="{{ route('customer.vehicles.index') }}" class="block p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 text-white" style="background-color: #2563eb;">
                <div class="flex justify-between items-center">
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-blue-100 uppercase tracking-wider">Total Vehicles</p>
                        <p class="text-4xl font-bold">{{ $vehiclesCount }}</p>
                    </div>
                    <div class="p-4 bg-white/20 rounded-full">
                        {{-- Ikon Mobil --}}
                        <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.125-.504 1.125-1.125V14.25m-17.25 4.5v-1.875a3.375 3.375 0 003.375-3.375h1.5a1.125 1.125 0 011.125 1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125h1.5a3.375 3.375 0 003.375 3.375z" />
                        </svg>
                    </div>
                </div>
            </a>

            <!-- Active Bookings -->
             {{-- Menggunakan inline style untuk memastikan warna tampil --}}
            <a href="{{ route('customer.bookings.index') }}" class="block p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 text-white" style="background-color: #eab308;">
                <div class="flex justify-between items-center">
                     <div class="space-y-1">
                        <p class="text-sm font-medium text-yellow-100 uppercase tracking-wider">Active Bookings</p>
                        <p class="text-4xl font-bold">{{ $activeBookings }}</p>
                    </div>
                    <div class="p-4 bg-white/20 rounded-full">
                        {{-- Ikon Kalender --}}
                        <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                           <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18M-4.5 12h18" />
                        </svg>
                    </div>
                </div>
            </a>
            
            <!-- Last Service -->
             {{-- Menggunakan inline style untuk memastikan warna tampil --}}
            <div class="p-6 rounded-xl shadow-lg text-white" style="background-color: #22c55e;">
                 <div class="flex justify-between items-center">
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-green-100 uppercase tracking-wider">Last Service</p>
                        <p class="text-2xl font-bold">{{ $lastServiceDate ?? 'N/A' }}</p>
                    </div>
                    <div class="p-4 bg-white/20 rounded-full">
                        {{-- Ikon Ceklis --}}
                       <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Aksi Utama & Aktivitas Terbaru --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
            {{-- Tombol Aksi --}}
            <div class="lg:col-span-1 space-y-4">
                <h2 class="text-xl font-semibold text-gray-800">Butuh Servis?</h2>
                <p class="text-gray-600">Jangan tunda perawatan mobil Anda. Buat jadwal servis sekarang dengan mudah.</p>
                <a href="{{ route('customer.bookings.create') }}" class="inline-flex items-center justify-center w-full px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-colors duration-300">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Buat Booking Baru
                </a>
            </div>

            {{-- Daftar Aktivitas Terbaru --}}
            <div class="lg:col-span-2">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Aktivitas Terbaru Anda</h2>
                <div class="bg-white rounded-lg shadow-md">
                    <ul class="divide-y divide-gray-200">
                        @forelse($recentBookings as $booking)
                        <li class="p-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <div class="flex items-center space-x-4">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $booking->serviceCategory->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $booking->vehicle->model }} - {{ $booking->booking_date->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="capitalize px-3 py-1 text-xs font-semibold rounded-full 
                                    @switch($booking->status)
                                        @case('completed')
                                        @case('paid')
                                            bg-green-100 text-green-800
                                            @break
                                        @case('in_progress')
                                            bg-yellow-100 text-yellow-800
                                            @break
                                        @default
                                            bg-gray-100 text-gray-800
                                    @endswitch">
                                    {{ str_replace('_', ' ', $booking->status) }}
                                </span>
                                <a href="{{ route('customer.bookings.show', $booking) }}" class="text-sm text-blue-600 hover:underline block mt-1">Lihat Detail</a>
                            </div>
                        </li>
                        @empty
                        <li class="p-6 text-center text-gray-500">
                            Belum ada aktivitas booking.
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

    </div>
</x-customer-layout>
