<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- Bagian Header Detail Booking --}}
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <h1 class="text-xl font-bold text-gray-800">Booking Details</h1>
                            <p class="text-sm text-gray-500">Code: {{ $booking->booking_code }}</p>
                        </div>
                        <span class="capitalize px-3 py-1 text-sm font-semibold rounded-full {{ $booking->status === 'paid' ? 'bg-green-100 text-green-800' : ($booking->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ str_replace('_',' ', $booking->status) }}
                        </span>
                    </div>

                    {{-- Informasi Detail Booking dalam Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4 text-sm text-gray-700 mb-6 border-t pt-6">
                        <div><strong>Customer:</strong> {{ $booking->customer?->user?->name ?? '-' }}</div>
                        <div><strong>Vehicle:</strong> {{ $booking->vehicle?->model }} ({{ $booking->vehicle?->license_plate }})</div>
                        <div><strong>Technician:</strong> {{ $booking->technician?->user?->name ?? '-' }}</div>
                        <div><strong>Created:</strong> {{ $booking->created_at->format('d M Y H:i') }}</div>
                        <div><strong>Service Category:</strong> {{ $booking->serviceCategory?->name }}</div>
                        <div><strong>Final Amount:</strong> {{ $booking->total_amount ? 'Rp '.number_format($booking->total_amount,0,',','.') : 'Not set' }}</div>
                        {{-- PERUBAHAN DI SINI: Tampilkan custom_request jika ada --}}
                                @if (strtolower($booking->serviceCategory->name) === 'lain-lain (custom)' && !empty($booking->custom_request))
                                    <div class="mt-2 text-xs text-amber-900 bg-amber-100 border-l-4 border-amber-500 p-2 rounded-r-lg">
                                        <p class="font-semibold">Catatan Khusus:</p>
                                        <p class="italic">{{ $booking->custom_request }}</p>
                                    </div>
                                @endif
                        <div class="md:col-span-2">
                            <strong>Customer Note:</strong>
                            <p class="text-gray-600 pl-2 border-l-2 ml-2 mt-1">{{ $booking->complaint_description ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <strong>Technician Note:</strong>
                            <p class="text-gray-600 pl-2 border-l-2 ml-2 mt-1">{{ $booking->notes ?? '-' }}</p>
                        </div>
                    </div>

                    {{-- Bagian Detail Servis & Spare Part --}}
                    <div class="mt-6 pt-6 border-t">

                        {{-- PERUBAHAN DI SINI: Logika pengecekan status langsung dimasukkan ke dalam @if --}}
                        @if(in_array($booking->status, ['completed', 'awaiting_payment']))
                            {{-- TAMPILKAN FORM EDIT JIKA ADMIN BOLEH MENGEDIT --}}
                            <form method="POST" action="{{ route('admin.bookings.details', $booking) }}" x-data="serviceItems(bookingDetails, sparePartPrices)" class="space-y-4">
                                @csrf
                                <h2 class="font-semibold text-lg mb-2">Input Service & Parts Details</h2>
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm border rounded">
                                        {{-- ... (Isi tabel sama seperti sebelumnya, tapi sekarang sepenuhnya bisa diedit) ... --}}
                                        <thead class="bg-gray-100">
                                            <tr class="text-left">
                                                <th class="p-2 w-40">Type</th>
                                                <th class="p-2">Item / Description</th>
                                                <th class="p-2 w-24">Qty</th>
                                                <th class="p-2 w-32">Unit Price</th>
                                                <th class="p-2 w-32">Subtotal</th>
                                                <th class="p-2 w-10"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <template x-for="(row, index) in rows" :key="index">
                                                <tr class="border-b">
                                                    <td class="p-2"><select x-model="row.type" :name="`items[${index}][type]`" @change="row.spare_part_id=''; updatePrice(index)" class="border rounded px-2 py-1 w-full"><option value="service">Service</option><option value="part">Spare Part</option></select></td>
                                                    <td class="p-2"><template x-if="row.type==='service'"><input type="text" x-model="row.description" :name="`items[${index}][description]`" placeholder="Service description" class="border rounded px-2 py-1 w-full" /></template><template x-if="row.type==='part'"><select x-model="row.spare_part_id" :name="`items[${index}][spare_part_id]`" @change="updatePrice(index)" class="border rounded px-2 py-1 w-full"><option value="">-- select part --</option>@foreach($spareParts as $sp)<option value="{{ $sp->id }}">{{ $sp->name }} (Stock: {{ $sp->stock_quantity }})</option>@endforeach</select></template></td>
                                                    <td class="p-2"><input type="number" min="1" x-model.number="row.quantity" :name="`items[${index}][quantity]`" class="border rounded w-full px-2 py-1"></td>
                                                    <td class="p-2"><input type="number" min="0" step="100" x-model.number="row.unit_price" :readonly="row.type==='part'" :name="`items[${index}][unit_price]`" class="border rounded w-full px-2 py-1"></td>
                                                    <td class="p-2 text-right" x-text="new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',minimumFractionDigits:0}).format(row.quantity * row.unit_price)"></td>
                                                    <td class="p-2 text-center"><button type="button" @click="removeRow(index)" class="text-red-500 hover:text-red-700 font-bold">&times;</button></td>
                                                </tr>
                                            </template>
                                        </tbody>
                                        <tfoot>
                                            <tr class="font-bold bg-gray-50"><td colspan="4" class="p-2 text-right">Total:</td><td class="p-2 text-right" x-text="new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',minimumFractionDigits:0}).format(rows.reduce((total, row) => total + (row.quantity * row.unit_price), 0))"></td><td></td></tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <button type="button" @click="addRow()" class="mt-2 text-sm bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">+ Add Item</button>
                                <div class="flex justify-end pt-4"><button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-semibold">Finalize & Notify Customer</button></div>
                            </form>
                        @elseif($booking->serviceDetails->isNotEmpty())
                             {{-- TAMPILKAN TABEL READ-ONLY JIKA SUDAH SELESAI DAN TIDAK BISA DIEDIT LAGI --}}
                            <h2 class="font-semibold text-lg mb-2">Service & Parts Details</h2>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm border rounded">
                                    <thead class="bg-gray-100"><tr class="text-left"><th class="p-2">Item / Description</th><th class="p-2">Qty</th><th class="p-2">Unit Price</th><th class="p-2">Subtotal</th></tr></thead>
                                    <tbody>
                                        @foreach($booking->serviceDetails as $item)
                                        <tr class="border-b"><td class="p-2">{{ $item->description ?: $item->sparePart->name }}</td><td class="p-2">{{ $item->quantity }}</td><td class="p-2 text-right">{{ 'Rp '.number_format($item->unit_price) }}</td><td class="p-2 text-right">{{ 'Rp '.number_format($item->total_price) }}</td></tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot><tr class="font-bold bg-gray-50"><td colspan="3" class="p-2 text-right">Total:</td><td class="p-2 text-right">{{ 'Rp '.number_format($booking->total_amount) }}</td></tr></tfoot>
                                </table>
                            </div>
                        @else
                             {{-- TAMPILKAN PESAN JIKA TEKNISI BELUM SELESAI --}}
                            <p class="text-center text-gray-500 py-4">Menunggu teknisi menyelesaikan pekerjaan...</p>
                        @endif

                    </div>

                    <div class="mt-6 pt-6 border-t">
                        <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="scripts">
        <script>
            function serviceItems(initialRows, pricesMap) {
                return {
                    rows: initialRows.length > 0 ? initialRows : [],
                    sparePartsPrices: pricesMap,
                    init() { if (this.rows.length === 0) { this.rows.push({ type: 'service', description: @json($booking->serviceCategory?->name), quantity: 1, unit_price: {{ $booking->serviceCategory?->price ?? 0 }}, spare_part_id: '' }); } },
                    addRow() {
                            this.rows.push({ type: 'service', description: '', spare_part_id: '', quantity: 1, unit_price: 0 });
                        },
                    removeRow(index) { this.rows.splice(index, 1) },
                    updatePrice(index) {
                        const id = this.rows[index].spare_part_id;
                        this.rows[index].unit_price = (id && this.sparePartsPrices[id]) ? parseFloat(this.sparePartsPrices[id]) : 0;
                    }
                }
            }
        </script>
        <script>
        // expose data for Alpine without HTML escaping issues
        window.bookingDetails = @json($detailsForJs);
        window.sparePartPrices = @json($sparePartsMap);
    </script>
</x-slot>
</x-app-layout>
