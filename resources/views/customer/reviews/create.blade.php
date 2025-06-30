<x-customer-layout title="Write Review">
    <h1 class="text-2xl font-semibold mb-4">Rate Your Service</h1>

    <div class="mb-4 bg-gray-100 p-4 rounded">
        <p><span class="font-semibold">Booking Code:</span> {{ $booking->booking_code }}</p>
    </div>

    <form method="POST" action="{{ route('customer.bookings.review.store', $booking) }}" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1 font-semibold">Rating (1-5) <span class="text-red-600">*</span></label>
            <select name="rating" class="w-full border rounded px-3 py-2" required>
                @for($i=1; $i<=5; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
            @error('rating')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block mb-1 font-semibold">Comment</label>
            <textarea name="comment" class="w-full border rounded px-3 py-2" rows="4">{{ old('comment') }}</textarea>
            @error('comment')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Submit Review</button>
        <a href="{{ route('customer.bookings.show', $booking) }}" class="ml-3 text-gray-600 hover:underline">Cancel</a>
    </form>
</x-customer-layout>
