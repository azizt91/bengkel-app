<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-xl font-semibold text-gray-800">Payments</h1>
                        <div class="flex space-x-2">
                            <a href="{{ url('/admin/payments/export') }}?{{ http_build_query(request()->query()) }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Export Excel
                            </a>
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-blue-800">Total Revenue</h3>
                            <p class="mt-2 text-2xl font-bold text-blue-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-yellow-800">Pending Payments</h3>
                            <p class="mt-2 text-2xl font-bold text-yellow-600">{{ $pendingPayments }}</p>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-red-800">Failed Payments</h3>
                            <p class="mt-2 text-2xl font-bold text-red-600">{{ $failedPayments }}</p>
                        </div>
                    </div>

                    <!-- Grid 3 kolom saja -->
                    <form action="{{ url('/admin/payments') }}" method="GET" class="mb-4">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Payment Status</label>
                                <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300" onchange="this.form.submit()">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                </select>
                            </div>
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" onchange="this.form.submit()"
                                    class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" onchange="this.form.submit()"
                                    class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                        </div>
                    </form>
                    @if(session('success'))
                        <div class="px-6 py-4 bg-green-50 text-green-800 text-sm">{{ session('success') }}</div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2">Date</th>
                                    <th class="px-4 py-2">Booking Code</th>
                                    <th class="px-4 py-2">Customer</th>
                                    <th class="px-4 py-2">Amount</th>
                                    <th class="px-4 py-2">Status</th>
                                    <th class="px-4 py-2">Payment Method</th>
                                    <th class="px-4 py-2">Proof</th>
                                    <th class="px-4 py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($payments as $payment)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-600">{{ $payment->payment_date ? $payment->payment_date->format('d M Y') : $payment->created_at->format('d M Y') }}</td>
                                        <td class="px-4 py-2">{{ $payment->booking->booking_code }}</td>
                                        <td class="px-4 py-2">{{ $payment->booking->customer->user->name }}</td>
                                        <td class="px-4 py-2">Rp {{ number_format($payment->amount,0,',','.') }}</td>
                                        <td class="px-4 py-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ 
                                                ($payment->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                                ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                'bg-red-100 text-red-800'))
                                            }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2">{{ $payment->payment_method ?? '-' }}</td>
                                        <td class="px-4 py-2">
                                                @if($payment->payment_method==='transfer' && $payment->proof_path)
                                                    <a href="{{ Storage::url($payment->proof_path) }}" target="_blank" class="text-blue-600 underline">View</a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        <td class="px-4 py-2">
                                            @if($payment->status === 'pending')
                                                <form method="POST" action="{{ route('admin.payments.update', $payment) }}" class="inline-block">
                                                    @csrf @method('PUT')
                                                    <input type="hidden" name="status" value="confirmed">
                                                    <button class="text-green-600" data-submit-spinner>Confirm</button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.payments.update', $payment) }}" class="inline-block">
                                                    @csrf @method('PUT')
                                                    <input type="hidden" name="status" value="failed">
                                                    <button class="text-red-600" data-submit-spinner>Mark as Failed</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-4 py-4 text-center text-gray-500">No payments found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4">
                        {{ $payments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

