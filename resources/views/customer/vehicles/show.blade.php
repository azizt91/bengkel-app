<x-customer-layout title="Vehicle Detail">
    <h1 class="text-2xl font-semibold mb-4">Vehicle Detail</h1>

    <div class="bg-white shadow rounded p-6 space-y-2">
        <p><span class="font-semibold">License Plate:</span> {{ $vehicle->license_plate }}</p>
        <p><span class="font-semibold">Brand:</span> {{ $vehicle->brand }}</p>
        <p><span class="font-semibold">Model:</span> {{ $vehicle->model }}</p>
        <p><span class="font-semibold">Year:</span> {{ $vehicle->year }}</p>
        <p><span class="font-semibold">Color:</span> {{ $vehicle->color }}</p>
    </div>

    <div class="bg-white shadow rounded p-6 mt-6 flex items-start space-x-6">
        <div>
            <h2 class="font-semibold mb-2">QR Code Pelacakan Servis</h2>
            <img src="{{ asset('storage/qrcodes/'.$vehicle->id.'.svg') }}" alt="QR Code" class="w-48 h-48 border" />
            <a href="{{ asset('storage/qrcodes/'.$vehicle->id.'.svg') }}" download class="text-blue-600 hover:underline mt-2 inline-block">Download QR</a>
            <form action="{{ route('customer.vehicles.regenerate-qr', $vehicle) }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="text-red-600 hover:underline">Regenerate QR</button>
            </form>
        </div>
        <p class="text-sm text-gray-600 max-w-xs">Scan QR ini untuk melihat riwayat servis kendaraan tanpa perlu login.</p>
    </div>

    <div class="mt-6">
        <a href="{{ route('customer.vehicles.edit', $vehicle) }}" class="bg-blue-600 text-white px-4 py-2 rounded">Edit</a>
        <a href="{{ route('customer.vehicles.index') }}" class="ml-3 text-gray-600 hover:underline">Back</a>
    </div>
</x-customer-layout>
