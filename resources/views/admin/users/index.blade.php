<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h1 class="text-xl font-semibold text-gray-800">Users</h1>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.users.create') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                               + New User
                            </a>
                        </div> 
                    </div>
                </div> 

                <div class="p-4 bg-white-50">
                    <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-2">
                        <select name="role" class="border-gray-300 rounded-md shadow-sm text-sm" onchange="this.form.submit()">
                            <option value="">All Roles</option>
                            @foreach(['admin','teknisi','pelanggan'] as $r)
                                <option value="{{ $r }}" @selected(request('role')==$r)>{{ ucfirst($r) }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search..." class="border-gray-300 rounded-md shadow-sm text-sm"/>
                    </form>
                </div>

                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full border-collapse text-sm text-left">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 border-b">Name</th>
                                <th class="px-4 py-2 border-b">Email</th>
                                <th class="px-4 py-2 border-b">Phone</th>
                                <th class="px-4 py-2 border-b">Role</th>
                                <th class="px-4 py-2 border-b">Registered</th>
                                <th class="px-4 py-2 border-b text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($users as $user)
                                <tr>
                                    <td class="px-4 py-2">{{ $user->name }}</td>
                                    <td class="px-4 py-2">{{ $user->email }}</td>
                                    <td class="px-4 py-2">{{ $user->phone ?? '-' }}</td>
                                    <td class="px-4 py-2 capitalize">{{ $user->role }}</td>
                                    <td class="px-4 py-2">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('admin.users.edit', $user) }}" class="text-indigo-600 hover:text-indigo-800" title="Edit">
                                                ✏️
                                            </a>
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Yakin ingin menghapus user ini?')" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                                                    🗑️
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-gray-500">No users found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
