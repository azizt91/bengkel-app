@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <x-input-label for="name" value="Name" />
        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name ?? '')" required />
        <x-input-error :messages="$errors->get('name')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email ?? '')" required />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="role" value="Role" />
        <select id="role" name="role" class="mt-1 block w-full border-gray-300 rounded-md" required>
            <option value="">-- Pilih Role --</option>
            @foreach(['admin','teknisi','pelanggan'] as $r)
                <option value="{{ $r }}"
                    @if(old('role') !== null)
                        @selected(old('role') == $r)
                    @else
                        @selected(($user->role ?? '') == $r)
                    @endif
                >
                    {{ ucfirst($r) }}
                </option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('role')" class="mt-2" />
    </div>
    <div class="md:col-span-2">
        <x-input-label for="password" value="Password" />
        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" :value="old('password')" @if(!isset($user)) required @endif />
        <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>
    <div class="md:col-span-2">
        <x-input-label for="password_confirmation" value="Confirm Password" />
        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" :value="old('password_confirmation')" @if(!isset($user)) required @endif />
    </div>
</div>
<div class="mt-4">
    <x-primary-button>{{ $submit ?? 'Save' }}</x-primary-button>
</div>
