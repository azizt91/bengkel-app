<x-customer-layout>
    <div class="flex justify-between mb-4">
        <h1 class="text-2xl font-semibold">My Vehicles</h1>
        <a href="{{ route('customer.vehicles.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Add Vehicle</a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    <div class="bg-white shadow rounded">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2">License Plate</th>
                    <th class="px-4 py-2">Brand</th>
                    <th class="px-4 py-2">Model</th>
                    <th class="px-4 py-2">Year</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($vehicles as $vehicle)
                    <tr>
                        <td class="px-4 py-2">{{ $vehicle->license_plate }}</td>
                        <td class="px-4 py-2">{{ $vehicle->brand }}</td>
                        <td class="px-4 py-2">{{ $vehicle->model }}</td>
                        <td class="px-4 py-2">{{ $vehicle->year }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('customer.vehicles.edit', $vehicle) }}" class="text-blue-600">Edit</a>
                            <form action="{{ route('customer.vehicles.destroy', $vehicle) }}" method="POST" class="inline" onsubmit="return confirm('Delete?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-4 text-center">No vehicles.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $vehicles->links() }}</div>
</x-customer-layout>
