<x-customer-layout title="Booking Detail">
    <h1 class="text-2xl font-semibold mb-4">Booking Detail</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="bg-blue-100 text-blue-800 p-2 rounded mb-4">{{ session('info') }}</div>
    @endif

    <div class="bg-white shadow rounded p-6 space-y-2">
        <p><span class="font-semibold">Code:</span> {{ $booking->booking_code }}</p>
        <p><span class="font-semibold">Vehicle:</span> {{ $booking->vehicle->license_plate }}</p>
        <p><span class="font-semibold">Category:</span> {{ $booking->serviceCategory->name }}</p>
        <p><span class="font-semibold">Date:</span> {{ $booking->booking_date->format('d M Y') }}</p>
        <p><span class="font-semibold">Est. Duration:</span>
            @php($dur = $booking->estimated_duration ?? $booking->serviceCategory->estimated_duration ?? null)
            @if($dur)
                @if($dur >= 60)
                    {{ number_format($dur/60,1) }} hrs ({{ $dur }} mins)
                @else
                    {{ $dur }} mins
                @endif
            @else
                -
            @endif</p>
        <p><span class="font-semibold">Technician:</span> {{ $booking->technician?->user?->name ?? '-' }}</p>
        <p><span class="font-semibold">Amount Due:</span> {{ $booking->estimated_cost ? 'Rp '.number_format($booking->estimated_cost,0,',','.') : '-' }}</p>
        <p><span class="font-semibold">Status:</span> <span class="capitalize">{{ $booking->status }}</span></p>
        <p><span class="font-semibold">Notes:</span> {{ $booking->notes ?: '-' }}</p>
    </div>

    @if($booking->status === 'completed' && $booking->estimated_cost && !$booking->payments->count())
        <div class="mt-4">
            <a href="{{ route('customer.bookings.payment.create', $booking) }}" class="bg-blue-600 text-white px-4 py-2 rounded">Pay Now</a>
        </div>
    @endif

    @if($booking->status === 'completed')
        <div class="mt-4">
            <a href="{{ route('customer.bookings.invoice.download', $booking) }}" class="bg-gray-700 text-white px-4 py-2 rounded">Download Invoice</a>
        </div>
    @endif

    @if($booking->status === 'completed' && !$booking->reviews->count())
        <div class="mt-4">
            <a href="{{ route('customer.bookings.review.create', $booking) }}" class="bg-green-600 text-white px-4 py-2 rounded">Write Review</a>
        </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('customer.bookings.index') }}" class="text-gray-600 hover:underline">Back to list</a>
    </div>
</x-customer-layout>
