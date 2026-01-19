<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Skpd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $users = User::when($search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('username', 'like', "%{$search}%");
            })
            ->paginate(5)
            ->withQueryString();

        return view('pages.user.index', compact('users', 'search'));
    }

    public function create()
    {
        return view('pages.user.form', [
            'user' => null,
            'title' => 'Tambah User',
            'skpds' => Skpd::all()  
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'username' => 'required|unique:users',
            'role'     => 'required',
            'skpd_id'  => 'nullable|exists:skpds,id',
            'password' => 'required|min:6|confirmed'
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'role'     => $request->role,
            'skpd_id'  => $request->skpd_id, 
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        return view('pages.user.form', [
            'user'  => $user,
            'title' => 'Edit User',
            'skpds' => Skpd::all()
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required',
            'username' => 'required|unique:users,username,' . $user->id,
            'role'     => 'required',
            'skpd_id'  => 'nullable|exists:skpds,id',
            'password' => 'nullable|min:6|confirmed'
        ]);

        $data = $request->only('name', 'username', 'role', 'skpd_id');

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus');
    }
}

