<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-xl font-semibold text-gray-800 mb-6">Edit User</h1>
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-500 @enderror">
                                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-500 @enderror">
                                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
    <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('phone') border-red-500 @enderror">
    @error('phone') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
</div>
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                {{-- <select name="role" id="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('role') border-red-500 @enderror">
                                    <option value="admin" @selected(old('role', $user->role) == 'admin')>Admin</option>
                                    <option value="teknisi" @selected(old('role', $user->role) == 'teknisi')>Teknisi</option>
                                    <option value="pelanggan" @selected(old('role', $user->role) == 'pelanggan')>Pelanggan</option>
                                </select> --}}
                                <select name="role" id="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('role') border-red-500 @enderror" required>
                                    <option value="">-- Pilih Role --</option>
                                    <option value="admin" @selected(old('role') !== null ? old('role') == 'admin' : $user->role == 'admin')>Admin</option>
                                    <option value="teknisi" @selected(old('role') !== null ? old('role') == 'teknisi' : $user->role == 'teknisi')>Teknisi</option>
                                    <option value="pelanggan" @selected(old('role') !== null ? old('role') == 'pelanggan' : $user->role == 'pelanggan')>Pelanggan</option>
                                </select>
                                @error('role') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password (leave empty to keep current)</label>
                                <input type="password" name="password" id="password"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('password') border-red-500 @enderror">
                                @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Update User
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="ml-4 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
