<x-customer-layout title="Edit Vehicle">
    <h1 class="text-2xl font-semibold mb-4">Edit Vehicle</h1>
    @include('customer.vehicles._form', ['vehicle' => $vehicle])
</x-customer-layout>
