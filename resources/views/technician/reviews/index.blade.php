<x-technician-layout title="Reviews">
    <h1 class="text-2xl font-semibold mb-6">Customer Reviews</h1>

    <div class="bg-white shadow rounded p-6 overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Customer</th>
                    <th class="px-4 py-2">Booking Code</th>
                    <th class="px-4 py-2">Rating</th>
                    <th class="px-4 py-2">Comment</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($reviews as $rev)
                    <tr>
                        <td class="px-4 py-2">{{ $rev->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-2">{{ $rev->customer?->user?->name ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $rev->booking?->booking_code ?? '-' }}</td>
                        <td class="px-4 py-2 text-yellow-500">★ {{ $rev->rating }}</td>
                        <td class="px-4 py-2">{{ $rev->comment }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-4 text-center text-gray-500">No reviews yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $reviews->links() }}
        </div>
    </div>
</x-technician-layout>
