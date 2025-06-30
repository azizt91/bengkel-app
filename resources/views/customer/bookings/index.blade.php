<x-customer-layout title="My Bookings">
    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-semibold">My Bookings</h1>
        <a href="{{ route('customer.bookings.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">New Booking</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2">Code</th>
                    <th class="px-4 py-2">Vehicle</th>
                    <th class="px-4 py-2">Category</th>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($bookings as $booking)
                    <tr>
                        <td class="px-4 py-2">{{ $booking->booking_code }}</td>
                        <td class="px-4 py-2">{{ $booking->vehicle->license_plate }}</td>
                        <td class="px-4 py-2">{{ $booking->serviceCategory->name }}</td>
                        <td class="px-4 py-2">{{ $booking->booking_date->format('d M Y') }}</td>
                        <td class="px-4 py-2 capitalize">{{ $booking->status }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('customer.bookings.show', $booking) }}" class="text-blue-600">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-4 text-center">No bookings.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $bookings->links() }}</div>
</x-customer-layout>
