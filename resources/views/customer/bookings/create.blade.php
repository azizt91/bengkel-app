<x-customer-layout title="New Booking">
    <h1 class="text-2xl font-semibold mb-4">Create Service Booking</h1>
    @include('customer.bookings._form', ['vehicles' => $vehicles, 'categories' => $categories])
</x-customer-layout>
