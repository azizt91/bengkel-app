<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $role = $request->query('role');
        $search = $request->query('q');

        $query = User::query()->latest();
        if ($role) {
            $query->where('role', $role);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        $users = $query->paginate(20);
        return view('admin.users.index', compact('users', 'role', 'search'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => ['required', 'string', 'max:20'],
            'role' => 'required|in:admin,teknisi,pelanggan',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        // Make sure the role exists in the roles table
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => $validated['role']]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'role' => $validated['role'],
            'password' => bcrypt($validated['password']),
        ]);
        // assign Spatie role so middleware `role:*` works
        $user->assignRole($validated['role']);
        // create technician profile if role is teknisi
        if ($validated['role'] === 'teknisi') {
            \App\Models\Technician::firstOrCreate(['user_id' => $user->id]);
        }
        if ($validated['role'] === 'pelanggan') {
            \App\Models\Customer::firstOrCreate(['user_id' => $user->id]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'role' => 'required|in:admin,teknisi,pelanggan',
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $data = $validated;
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);
        // sync Spatie role (replace any previous role)
        if (isset($validated['role'])) {
            $user->syncRoles([$validated['role']]);
            // ensure technician profile present/removed accordingly
            if ($validated['role'] === 'teknisi') {
                \App\Models\Technician::firstOrCreate(['user_id' => $user->id]);
            } else {
                \App\Models\Technician::where('user_id', $user->id)->delete();
            }
            // handle customer profile
            if ($validated['role'] === 'pelanggan') {
                \App\Models\Customer::firstOrCreate(['user_id' => $user->id]);
            } else {
                \App\Models\Customer::where('user_id', $user->id)->delete();
            }
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}
