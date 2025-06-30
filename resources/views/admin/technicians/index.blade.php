<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 flex items-center justify-between">
                    <h1 class="text-xl font-semibold text-gray-800">Technicians</h1>
                    <form method="GET">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search..." class="border-gray-300 rounded-md shadow-sm text-sm"/>
                    </form>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2">Employee ID</th>
                                    <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Email</th>
                                <th class="px-4 py-2">Phone</th>
                                <th class="px-4 py-2">Active Bookings</th>
                                    <th class="px-4 py-2">Avg Rating</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($technicians as $tech)
                                <tr>
                                    <td class="px-4 py-2">{{ $tech->employee_id }}</td>
                                    <td class="px-4 py-2">{{ $tech->user->name }}</td>
                                    <td class="px-4 py-2">{{ $tech->user->email }}</td>
                                    <td class="px-4 py-2">{{ $tech->user->phone ?? '-' }}</td>
                                    <td class="px-4 py-2 text-center">{{ $tech->active_bookings_count }}</td>
                                    <td class="px-4 py-2 text-center">{{ $tech->reviews_avg_rating ? number_format($tech->reviews_avg_rating,1) : '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6"><x-empty-state message="No technicians."/></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4">
                    {{ $technicians->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
