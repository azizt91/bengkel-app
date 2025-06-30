@props(['title' => 'Dashboard'])

<x-app-layout>

    @if (isset($scripts))
        <x-slot name="scripts">
            {{ $scripts }}
        </x-slot>
    @endif
    
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </div>
</x-app-layout>

    


