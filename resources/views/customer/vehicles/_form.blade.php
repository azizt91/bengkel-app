@php
    $isEdit = isset($vehicle);
@endphp

<form method="POST" action="{{ $isEdit ? route('customer.vehicles.update', $vehicle) : route('customer.vehicles.store') }}" class="space-y-4">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div>
        <label class="block mb-1 font-semibold">License Plate <span class="text-red-600">*</span></label>
        <input type="text" name="license_plate" value="{{ old('license_plate', $vehicle->license_plate ?? '') }}" class="w-full border rounded px-3 py-2" required>
        @error('license_plate')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block mb-1 font-semibold">Brand <span class="text-red-600">*</span></label>
            <input type="text" name="brand" value="{{ old('brand', $vehicle->brand ?? '') }}" class="w-full border rounded px-3 py-2" required>
            @error('brand')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block mb-1 font-semibold">Model <span class="text-red-600">*</span></label>
            <input type="text" name="model" value="{{ old('model', $vehicle->model ?? '') }}" class="w-full border rounded px-3 py-2" required>
            @error('model')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block mb-1 font-semibold">Year</label>
            <input type="number" name="year" value="{{ old('year', $vehicle->year ?? '') }}" class="w-full border rounded px-3 py-2" min="1900" max="2100">
            @error('year')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block mb-1 font-semibold">Color</label>
            <input type="text" name="color" value="{{ old('color', $vehicle->color ?? '') }}" class="w-full border rounded px-3 py-2">
            @error('color')<p class="text-red-600 text-sm">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="pt-4">
        <button class="bg-blue-600 text-white px-4 py-2 rounded">{{ $isEdit ? 'Update' : 'Save' }}</button>
        <a href="{{ route('customer.vehicles.index') }}" class="ml-3 text-gray-600 hover:underline">Cancel</a>
    </div>
</form>
