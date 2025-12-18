<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ManajemenPegawaiController extends Controller
{
    public function index()
    {
        $tellers = User::where('role', 1) // 1 = teller
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('manajer.manajemen-pegawai.index', compact('tellers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'is_active' => 'required|in:0,1',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'is_active.required' => 'Status wajib dipilih',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 1, // Set role sebagai teller
            'is_active' => $validated['is_active'],
        ]);

        return redirect()
            ->route('manajer.manajemen-pegawai.index')
            ->with('success', 'User teller berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $user = User::where('role', 1)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id)
            ],
            'password' => 'nullable|string|min:6|confirmed',
            'is_active' => 'required|in:0,1',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'is_active.required' => 'Status wajib dipilih',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'is_active' => $validated['is_active'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()
            ->route('manajer.manajemen-pegawai.index')
            ->with('success', 'User teller berhasil diupdate');
    }

    public function edit($id)
    {
        $user = User::where('role', 1)->findOrFail($id);
        
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'is_active' => $user->is_active,
        ]);
    }

    public function destroy($id)
    {
        $user = User::where('role', 1)->findOrFail($id);
        
        $user->delete();

        return redirect()
            ->route('manajer.manajemen-pegawai.index')
            ->with('success', 'User teller berhasil dihapus');
    }
}