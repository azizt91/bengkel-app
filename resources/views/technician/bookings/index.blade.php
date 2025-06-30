<x-technician-layout title="Bookings">
    <div class="space-y-6">
        {{-- Bagian Header dengan Judul dan Filter --}}
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
            <h1 class="text-2xl font-semibold text-gray-800">My Bookings</h1>
            <form method="GET" class="inline-block">
                <div class="flex items-center space-x-2">
                    <label for="status" class="text-sm font-medium text-gray-700">Filter by status:</label>
                    <select name="status" id="status" onchange="this.form.submit()" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">All</option>
                        @foreach(['available', 'pending', 'in_progress', 'completed'] as $s)
                            <option value="{{ $s }}" @selected(request('status')==$s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- Grid Kartu Booking yang Responsif --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($bookings as $booking)
                {{-- Setiap booking menjadi sebuah card --}}
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 flex flex-col overflow-hidden">
                    
                    {{-- Card Header: Informasi pelanggan dan Tombol Aksi --}}
                    <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                        <div>
                            <p class="font-semibold text-gray-900 truncate">{{ $booking->customer->user->name }}</p>
                            <p class="text-sm text-gray-600">{{ $booking->vehicle->model }}</p>
                        </div>
                        {{-- Tombol Aksi dengan logika baru --}}
                        <div class="flex-shrink-0 ml-4">
                            @if(!$booking->technician_id)
                                <form method="POST" action="{{ route('technician.bookings.claim', $booking) }}">
                                    @csrf
                                    <button type="submit" data-submit-spinner class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition-colors text-sm">
                                        Claim
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('technician.bookings.show', $booking) }}" class="inline-flex items-center justify-center px-3 py-1.5 border border-gray-300 text-gray-700 bg-white hover:bg-gray-50 font-semibold rounded-md shadow-sm transition-colors text-xs">
                                    <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                    Manage
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Card Body: Detail servis, tanggal, dan status --}}
                    <div class="p-4 flex-grow flex flex-col justify-between">
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs text-gray-500">Service</p>
                                <p class="font-medium text-gray-800">{{ $booking->serviceCategory->name }}</p>
                                
                                {{-- PERUBAHAN DI SINI: Tampilkan custom_request jika ada --}}
                                @if (strtolower($booking->serviceCategory->name) === 'lain-lain (custom)' && !empty($booking->custom_request))
                                    <div class="mt-2 text-xs text-amber-900 bg-amber-100 border-l-4 border-amber-500 p-2 rounded-r-lg">
                                        <p class="font-semibold">Catatan Khusus:</p>
                                        <p class="italic">{{ $booking->custom_request }}</p>
                                    </div>
                                @endif
                            </div>
                             <div>
                                <p class="text-xs text-gray-500">Booking Date</p>
                                <p class="font-medium text-gray-800">{{ $booking->booking_date->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Booking Code</p>
                                <p class="font-mono text-sm text-gray-600 bg-gray-100 px-2 py-0.5 rounded inline-block">#{{ $booking->booking_code }}</p>
                            </div>
                        </div>

                        {{-- Bagian Status --}}
                        <div class="mt-4 pt-4 border-t border-gray-200 flex justify-start items-center">
                            <span class="capitalize inline-block text-center px-3 py-1 text-xs font-semibold rounded-full 
                                @if(!$booking->technician_id)
                                    bg-cyan-100 text-cyan-800
                                @else
                                    @switch($booking->status)
                                        @case('completed') bg-green-100 text-green-800 @break
                                        @case('in_progress') bg-yellow-100 text-yellow-800 @break
                                        @default bg-gray-100 text-gray-800
                                    @endswitch
                                @endif
                            ">
                                {{ $booking->technician_id ? str_replace('_',' ',$booking->status) : 'Available' }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="md:col-span-2 xl:col-span-3 bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
                    <p>No bookings found for the selected filter.</p>
                </div>
            @endforelse
        </div>
        
        @if($bookings->hasPages())
            <div class="mt-4">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</x-technician-layout>
