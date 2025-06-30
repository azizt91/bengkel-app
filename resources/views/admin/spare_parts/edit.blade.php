<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Header Halaman --}}
                    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Edit Spare Part</h1>

                    {{-- Form utama --}}
                    <form method="POST" action="{{ route('admin.spare-parts.update', $sparePart) }}">
                        @method('PUT') {{-- Penting untuk metode update --}}

                        {{-- Memuat form dari file partial --}}
                        @include('admin.spare_parts._form')

                        {{-- Tombol Aksi --}}
                        <div class="mt-8 flex justify-end space-x-4">
                            <a href="{{ route('admin.spare-parts.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
