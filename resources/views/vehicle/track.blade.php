<x-layout title="Riwayat Servis">
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Riwayat Servis Kendaraan</h1>

    <div class="bg-white shadow rounded p-4 mb-6">
        <h2 class="text-lg font-semibold mb-2">Informasi Kendaraan</h2>
        <p><strong>Plat Nomor:</strong> {{ $vehicle->license_plate }}</p>
        <p><strong>Merek / Model:</strong> {{ $vehicle->brand }} {{ $vehicle->model }}</p>
        @if($vehicle->year)
            <p><strong>Tahun:</strong> {{ $vehicle->year }}</p>
        @endif
    </div>

    <div class="bg-white shadow rounded p-4">
        <h2 class="text-lg font-semibold mb-2">Riwayat Servis</h2>
        @forelse($vehicle->serviceBookings as $booking)
            <div class="border-b py-2">
                <p class="font-medium">#{{ $booking->id }} - {{ $booking->created_at->format('d M Y') }} - Status: {{ ucfirst($booking->status) }}</p>
                @if($booking->serviceProgress->count())
                    <ul class="list-disc list-inside text-sm text-gray-700 ml-4 mt-1">
                        @foreach($booking->serviceProgress as $progress)
                            <li>{{ $progress->created_at->format('d M Y H:i') }} - {{ $progress->description }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @empty
            <p class="text-gray-500">Belum ada riwayat servis.</p>
        @endforelse
    </div>
</div>
</x-layout>
