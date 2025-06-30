<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h1 class="text-xl font-semibold text-gray-800">Bookings</h1>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.bookings.export') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Export Excel
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="p-6 bg-gray-50">
                    <form action="{{ route('admin.bookings.index') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="this.form.submit()">
                                    @foreach($statusOptions as $value => $label)
                                         <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                     @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="technician" class="block text-sm font-medium text-gray-700">Technician</label>
                                <select id="technician" name="technician" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="this.form.submit()">
                                    <option value="">All Technicians</option>
                                    @foreach($technicians as $tech)
                                         <option value="{{ $tech->id }}" {{ request('technician') == $tech->id ? 'selected' : '' }}>
                                             {{ $tech->user->name }}
                                         </option>
                                     @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" onchange="this.form.submit()" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" onchange="this.form.submit()" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Table Section -->
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Technician</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Services</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($bookings as $booking)
                                    <tr>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->booking_code }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->customer->user->name }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $booking->vehicle->model }}</td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @switch($booking->status)
                                                    @case('new')
                                                        bg-blue-100 text-blue-800
                                                        @break
                                                    @case('in_progress')
                                                        bg-yellow-100 text-yellow-800
                                                        @break
                                                    @case('completed')
                                                        bg-green-100 text-green-800
                                                        @break
                                                    @case('cancelled')
                                                        bg-red-100 text-red-800
                                                        @break
                                                @endswitch
                                            ">
                                                {{ str_replace('_', ' ', ucfirst($booking->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $booking->technician?->user->name ?? '-' }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div class="text-sm">
                                                @php
                                                    $items = $booking->serviceDetails->pluck('description');
                                                @endphp
                                                {{ $items->isNotEmpty() ? $items->join(', ', ', dan ') : '-' }}
                                            </div>
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $booking->created_at->format('d M Y H:i') }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                        {{ $booking->estimated_cost ? 'Rp '.number_format($booking->estimated_cost,0,',','.') : '-' }}
                                        </td>
                                        <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.bookings.show', $booking) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900">
                                                    View
                                                </a>
                                                @if($booking->status === 'new')
                                                    <form action="{{ route('admin.bookings.assign-technician', $booking) }}" 
                                                          method="POST" 
                                                          class="inline">
                                                        @csrf
                                                        <input type="hidden" name="technician_id" value="{{ $booking->technician_id }}">
                                                        <button type="submit" 
                                                                class="text-green-600 hover:text-green-900">
                                                            Assign
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-4 py-4 text-center text-sm text-gray-500">
                                            <x-empty-state message="No bookings found."/>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4">
                    {{ $bookings->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
