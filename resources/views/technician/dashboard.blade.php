<x-technician-layout title="Technician Dashboard">
    <div class="space-y-8">
        {{-- Bagian Header Selamat Datang --}}
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ auth()->user()->name }}!</h1>
            <p class="mt-1 text-gray-600">Berikut adalah ringkasan pekerjaan Anda hari ini.</p>
        </div>

        {{-- Kartu Statistik dengan warna solid dan ikon baru --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Today's Jobs -->
            <div class="p-6 rounded-xl shadow-lg text-white" style="background-color: #3b82f6;">
                <div class="flex justify-between items-start">
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-blue-100 uppercase tracking-wider">Today's Jobs</p>
                        <p class="text-4xl font-bold">{{ $todayJobs }}</p>
                    </div>
                    {{-- Ikon Kalender Hari Ini --}}
                    <svg class="w-8 h-8 text-white opacity-70" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0h18M-4.5 12h18" /></svg>
                </div>
            </div>

            <!-- Pending -->
            <div class="p-6 rounded-xl shadow-lg text-white" style="background-color: #6b7280;">
                <div class="flex justify-between items-start">
                     <div class="space-y-1">
                        <p class="text-sm font-medium text-gray-100 uppercase tracking-wider">Pending</p>
                        <p class="text-4xl font-bold">{{ $pending }}</p>
                    </div>
                    {{-- Ikon Jam Pasir --}}
                    <svg class="w-8 h-8 text-white opacity-70" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
            
            <!-- In Progress -->
            <div class="p-6 rounded-xl shadow-lg text-white" style="background-color: #f59e0b;">
                 <div class="flex justify-between items-start">
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-amber-100 uppercase tracking-wider">In Progress</p>
                        <p class="text-4xl font-bold">{{ $inProgress }}</p>
                    </div>
                    {{-- Ikon Perkakas --}}
                    <svg class="w-8 h-8 text-white opacity-70" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 004.486-6.336l-3.276 3.277a3.004 3.004 0 01-4.243-4.243l3.275-3.275a4.5 4.5 0 00-6.336 4.486c.046.58.106 1.193.14 1.743m-.233-5.108a3.004 3.004 0 00-4.243-4.243L6.837 7.93l-1.12-1.12a.5.5 0 01.708-.708l1.12 1.12z" /></svg>
                </div>
            </div>

            <!-- Completed Today -->
            <div class="p-6 rounded-xl shadow-lg text-white" style="background-color: #16a34a;">
                 <div class="flex justify-between items-start">
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-green-100 uppercase tracking-wider">Completed Today</p>
                        <p class="text-4xl font-bold">{{ $completed }}</p>
                    </div>
                    {{-- Ikon Ceklis Ganda --}}
                    <svg class="w-8 h-8 text-white opacity-70" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
        </div>
        
        {{-- Daftar Pekerjaan Aktif --}}
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Your Active Jobs</h2>
            <div class="bg-white rounded-lg shadow-md">
                <ul class="divide-y divide-gray-200">
                    @forelse($myActiveJobs as $booking)
                    <li class="p-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <div class="flex items-center space-x-4">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $booking->serviceCategory->name }}</p>
                                <p class="text-sm text-gray-500">
                                    {{ $booking->vehicle->model }} ({{$booking->vehicle->license_plate}}) - Cust: {{ $booking->customer->user->name }}
                                </p>
                            </div>
                        </div>
                        <div class="text-right flex items-center space-x-4">
                            <span class="capitalize px-3 py-1 text-xs font-semibold rounded-full 
                                {{ $booking->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800 animate-pulse' : 'bg-gray-100 text-gray-800' }}">
                                {{ str_replace('_', ' ', $booking->status) }}
                            </span>
                            <a href="{{ route('technician.bookings.show', $booking) }}" class="text-sm bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-600 transition-colors">
                                Manage
                            </a>
                        </div>
                    </li>
                    @empty
                    <li class="p-6 text-center text-gray-500">
                        Tidak ada pekerjaan aktif yang ditugaskan untuk Anda saat ini.
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>

    </div>
</x-technician-layout>
