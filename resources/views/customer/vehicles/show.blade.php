<x-customer-layout title="Vehicle Detail">
    <h1 class="text-2xl font-semibold mb-4">Vehicle Detail</h1>

    <div class="bg-white shadow rounded p-6 space-y-2">
        <p><span class="font-semibold">License Plate:</span> {{ $vehicle->license_plate }}</p>
        <p><span class="font-semibold">Brand:</span> {{ $vehicle->brand }}</p>
        <p><span class="font-semibold">Model:</span> {{ $vehicle->model }}</p>
        <p><span class="font-semibold">Year:</span> {{ $vehicle->year }}</p>
        <p><span class="font-semibold">Color:</span> {{ $vehicle->color }}</p>
    </div>

    <div class="mt-6">
        <a href="{{ route('customer.vehicles.edit', $vehicle) }}" class="bg-blue-600 text-white px-4 py-2 rounded">Edit</a>
        <a href="{{ route('customer.vehicles.index') }}" class="ml-3 text-gray-600 hover:underline">Back</a>
    </div>
</x-customer-layout>
