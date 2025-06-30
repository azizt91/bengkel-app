@csrf
<div class="space-y-6">

    {{-- Field: Part Code --}}
    <div>
        <label for="part_code" class="block text-sm font-medium text-gray-700">Part Code *</label>
        <input type="text" name="part_code" id="part_code" value="{{ old('part_code', $sparePart->part_code ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        @error('part_code')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Field: Name --}}
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Name *</label>
        <input type="text" name="name" id="name" value="{{ old('name', $sparePart->name ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
        @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Grid untuk Price dan Stock (Responsif) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Field: Price --}}
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700">Price (Rp) *</label>
            <input type="number" name="price" id="price" step="1000" min="0" value="{{ old('price', $sparePart->price ?? 0) }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            @error('price')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Field: Stock Quantity --}}
        <div>
            <label for="stock_quantity" class="block text-sm font-medium text-gray-700">Stock Qty *</label>
            <input type="number" name="stock_quantity" id="stock_quantity" min="0" value="{{ old('stock_quantity', $sparePart->stock_quantity ?? 0) }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
            @error('stock_quantity')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Grid untuk Brand dan Category (Responsif) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Field: Brand --}}
        <div>
            <label for="brand" class="block text-sm font-medium text-gray-700">Brand</label>
            <input type="text" name="brand" id="brand" value="{{ old('brand', $sparePart->brand ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            @error('brand')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Field: Category --}}
        <div>
            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
            <input type="text" name="category" id="category" value="{{ old('category', $sparePart->category ?? '') }}"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            @error('category')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    {{-- Field: Is Active (Checkbox) --}}
    <div class="flex items-start">
        <div class="flex h-5 items-center">
            <input id="is_active" name="is_active" type="checkbox" value="1"
                   {{ old('is_active', ($sparePart->is_active ?? true)) ? 'checked' : '' }}
                   class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
        </div>
        <div class="ml-3 text-sm">
            <label for="is_active" class="font-medium text-gray-700">Active</label>
            <p class="text-gray-500">Hilangkan centang untuk menonaktifkan suku cadang.</p>
        </div>
    </div>
</div>
