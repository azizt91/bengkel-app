@php
    $isEdit = isset($booking);
@endphp

<form method="POST" action="{{ route('customer.bookings.store') }}" class="space-y-4">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block mb-1 font-semibold">Vehicle <span class="text-red-600">*</span></label>
            <select name="vehicle_id" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Select Vehicle --</option>
                @foreach($vehicles as $id => $plate)
                    <option value="{{ $id }}" @selected(old('vehicle_id')==$id)>{{ $plate }}</option>
                @endforeach
            </select>
            @error('vehicle_id')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block mb-1 font-semibold">Service Category <span class="text-red-600">*</span></label>
            <select name="service_category_id" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $id => $name)
                    <option value="{{ $id }}" @selected(old('service_category_id')==$id)>{{ $name }}</option>
                @endforeach
            </select>
            @error('service_category_id')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
    </div>

    <div>
        <label class="block mb-1 font-semibold">Preferred Date <span class="text-red-600">*</span></label>
        <input type="date" name="booking_date" value="{{ old('booking_date', now()->toDateString()) }}" class="w-full border rounded px-3 py-2" required>
        @error('booking_date')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block mb-1 font-semibold">Notes</label>
        <textarea name="notes" class="w-full border rounded px-3 py-2" rows="4">{{ old('notes') }}</textarea>
        @error('notes')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </div>

    <div id="customRequestWrapper" class="hidden">
        <label class="block mb-1 font-semibold">Custom Request <span class="text-red-600">*</span></label>
        <input type="text" name="custom_request" value="{{ old('custom_request') }}" class="w-full border rounded px-3 py-2">
        @error('custom_request')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </div>

    <div class="pt-4">
        <button class="bg-blue-600 text-white px-4 py-2 rounded">Submit Booking</button>
        <a href="{{ route('customer.bookings.index') }}" class="ml-3 text-gray-600 hover:underline">Cancel</a>
    </div>
@push('scripts')
<script>
    const categorySelect = document.querySelector('select[name=service_category_id]');
    const customWrapper = document.getElementById('customRequestWrapper');
    const customCategoryName = 'Lain-lain (Custom)';

    function toggleCustom() {
        const selectedText = categorySelect.options[categorySelect.selectedIndex]?.text;
        if (selectedText === customCategoryName) {
            customWrapper.classList.remove('hidden');
        } else {
            customWrapper.classList.add('hidden');
        }
    }
    categorySelect.addEventListener('change', toggleCustom);
    // initial
    toggleCustom();
</script>
@endpush
</form>
