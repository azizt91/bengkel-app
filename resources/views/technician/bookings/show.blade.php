<x-technician-layout title="Booking Manage">
    {{-- Ini adalah wrapper utama yang memberikan jarak vertikal (margin-top)
         antar elemen di dalamnya. Anda bisa mengubah angka 8 (menjadi 6, 10, dll.)
         untuk menyesuaikan jaraknya. --}}
    <div class="space-y-6 md:space-y-8">

        {{-- Header --}}

        <header class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800 md:text-3xl">
                Manage Booking
            </h1>
            <a href="{{ route('technician.bookings.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                Back to List
            </a>
        </header>

        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-800 p-4 rounded-lg" role="alert">
                <div class="flex">
                    <div class="py-1">
                        <svg class="h-6 w-6 text-green-500 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-bold">Success</p>
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Detail Booking Card --}}
        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Booking Details
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Ringkasan informasi pemesanan pelanggan.
                </p>
            </div>
            <div class="border-t border-gray-200 px-6 py-5">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2 md:grid-cols-3">
                    <div class="sm:col-span-1 mt-4 mb-4">
                        <dt class="text-sm font-medium text-gray-500">Booking Code</dt>
                        <dd class="mt-1 text-sm font-semibold text-gray-900">{{ $booking->booking_code }}</dd>
                    </div>
                    <div class="sm:col-span-1 mt-4 mb-4">
                        <dt class="text-sm font-medium text-gray-500">Customer</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->customer->user->name }}</dd>
                    </div>
                    <div class="sm:col-span-1 mt-4 mb-4">
                        <dt class="text-sm font-medium text-gray-500">Vehicle</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->vehicle->license_plate }}</dd>
                    </div>
                    <div class="sm:col-span-1 mb-4">
                        <dt class="text-sm font-medium text-gray-500">Service Category</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->serviceCategory->name }}</dd>
                                {{-- PERUBAHAN DI SINI: Tampilkan custom_request jika ada --}}
                                @if (strtolower($booking->serviceCategory->name) === 'lain-lain (custom)' && !empty($booking->custom_request))
                                    <div class="mt-2 text-xs text-amber-900 bg-amber-100 border-l-4 border-amber-500 p-2 rounded-r-lg">
                                        <p class="italic">{{ $booking->custom_request }}</p>
                                    </div>
                                @endif
                    </div>
                    <div class="sm:col-span-1 mb-4">
                        <dt class="text-sm font-medium text-gray-500">Booking Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $booking->booking_date->format('d F Y') }}</dd>
                    </div>
                    <div class="sm:col-span-1 mb-4">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            <span class="capitalize inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full {{ $booking->status === 'completed' ? 'bg-green-100 text-green-800' : ($booking->status === 'awaiting_review' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ str_replace('_',' ',$booking->status) }}
                            </span>
                        </dd>
                    </div>
                    <div class="sm:col-span-3 mb-4">
                        <dt class="text-sm font-medium text-gray-500">Customer Note</dt>
                        <dd class="mt-1 text-sm text-gray-900 prose prose-sm max-w-none">{{ $booking->complaint_description ?? '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- Form Update Card --}}
        <form method="POST" action="{{ route('technician.bookings.update', $booking) }}" class="bg-white overflow-hidden shadow-sm rounded-lg">
            @csrf
            @method('PUT')

            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Update Service Progress
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Perbarui status, perkiraan durasi, dan tambahkan catatan internal untuk admin.
                </p>
            </div>

            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Update Status</label>
                        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                            @foreach(['pending', 'in_progress', 'completed'] as $s)
                                <option value="{{ $s }}" @selected(old('status', $booking->status) == $s)>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="estimated_duration" class="block text-sm font-medium text-gray-700">Estimated Duration (minutes)</label>
                        <input id="estimated_duration" type="number" name="estimated_duration" value="{{ old('estimated_duration', $booking->estimated_duration) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="e.g., 60">
                    </div>
                </div>

                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Technician Note</label>
                    <div class="mt-1">
                        <textarea id="notes" name="notes" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="e.g., Oil needs 4L, front brake pads are thin.">{{ old('notes', $booking->notes) }}</textarea>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">This note is only visible to the Admin.</p>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 bg-gray-50 px-6 py-4">
                <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Save Changes
                </button>
            </div>
        </form>

    </div> {{-- Penutup untuk div.space-y-8 --}}

</x-technician-layout>
