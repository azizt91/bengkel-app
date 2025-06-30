<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h1 class="text-xl font-semibold text-gray-800 mb-4">WhatsApp Fonnte Settings</h1>

                    @if(session('success'))
                        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="token" class="block text-sm font-medium text-gray-700">Fonnte Token</label>
                            <input type="text" id="token" name="token" value="{{ old('token', $token) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('token')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <label for="url" class="block text-sm font-medium text-gray-700">Fonnte Base URL</label>
                            <input type="url" id="url" name="url" value="{{ old('url', $url) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            @error('url')<span class="text-sm text-red-600">{{ $message }}</span>@enderror
                        </div>
                        <div>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
