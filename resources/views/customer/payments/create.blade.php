<x-customer-layout title="Payment">
    <h1 class="text-2xl font-semibold mb-4">Submit Payment</h1>

    <div class="mb-4 bg-gray-100 p-4 rounded">
        <p><span class="font-semibold">Booking Code:</span> {{ $booking->booking_code }}</p>
        <p><span class="font-semibold">Amount Due:</span> Rp {{ $booking->estimated_cost ? number_format($booking->estimated_cost,0,',','.') : 'N/A' }}</p>
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ route('customer.bookings.payment.store', $booking) }}" class="space-y-4">
        @csrf
        <div>
            <label class="block mb-1 font-semibold">Payment Method <span class="text-red-600">*</span></label>
            <select name="payment_method" class="w-full border rounded px-3 py-2" required>
            <option value="">Metode Pembayaran</option>
                <option value="transfer">Transfer Bank</option>
                <option value="credit_card">Kartu Kredit</option>
                <option value="cash">Cash</option>
            </select>
            @error('payment_method')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block mb-1 font-semibold">Amount <span class="text-red-600">*</span></label>
            <input type="number" name="amount" min="0" step="0.01" value="{{ old('amount', $booking->estimated_cost) }}" class="w-full border rounded px-3 py-2" required>
            @error('amount')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block mb-1 font-semibold">Notes</label>
            <textarea name="notes" class="w-full border rounded px-3 py-2" rows="3">{{ old('notes') }}</textarea>
            @error('notes')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>

        <div id="proof-upload" class="hidden">
            <label class="block mb-1 font-semibold">Upload Bukti Transfer</label>
            <input type="file" name="transfer_proof" accept="image/*" class="w-full border rounded px-3 py-2">
            @error('transfer_proof')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>

        @push('scripts')
        <script>
            const methodSelect = document.querySelector('select[name=payment_method]');
            const proofDiv = document.getElementById('proof-upload');
            function toggleProof(){
                proofDiv.classList.toggle('hidden', methodSelect.value !== 'transfer');
            }
            methodSelect.addEventListener('change', toggleProof);
            toggleProof();
        </script>
        @endpush

        <button class="bg-blue-600 text-white px-4 py-2 rounded">Submit</button>
        <a href="{{ route('customer.bookings.show', $booking) }}" class="ml-3 text-gray-600 hover:underline">Cancel</a>
    </form>
</x-customer-layout>
