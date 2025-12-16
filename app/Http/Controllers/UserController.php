<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('user.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::where('role_status', true)->get();
        return view('user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role_id'  => 'required|exists:role,id',
            'status'   => 'required|boolean',
        ]);

        User::createUser($request->all());

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user  = User::findOrFail($id);
        $roles = Role::where('role_status', true)->get();

        return view('user.edit', compact('user', 'roles'));
    }

    public function show($id)
    {
        $user = User::with([
                'role'
                // 'pegawai'
            ])
            ->findOrFail($id);

        return view('user.show', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'role_id'  => 'required|exists:role,id',
            'status'   => 'required|boolean',
        ]);

        $user->updateUser($request->all());

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->deleteUser();

        return redirect()
            ->route('user.index')
            ->with('success', 'User berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->toggleStatus();

            return response()->json([
                'success' => true,
                'message' => 'Status user berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status user.'
            ], 500);
        }
    }
}
