<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Services\LayananPengguna;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ManajemenPegawaiController extends Controller
{
    protected $layananPengguna;

    public function __construct(LayananPengguna $layananPengguna)
    {
        $this->layananPengguna = $layananPengguna;
    }

    public function index()
    {
        $tellers = $this->layananPengguna->getAllTellers();
        
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

        $this->layananPengguna->createTeller($validated);

        return redirect()
            ->route('manajer.manajemen-pegawai.index')
            ->with('success', 'User teller berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $user = $this->layananPengguna->getTellerById($id);

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

        $this->layananPengguna->updateTeller($id, $validated);

        return redirect()
            ->route('manajer.manajemen-pegawai.index')
            ->with('success', 'User teller berhasil diupdate');
    }

    public function edit($id)
    {
        $user = $this->layananPengguna->getTellerById($id);
        
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'is_active' => $user->is_active,
        ]);
    }

    public function destroy($id)
    {
        $this->layananPengguna->deleteTeller($id);

        return redirect()
            ->route('manajer.manajemen-pegawai.index')
            ->with('success', 'User teller berhasil dihapus');
    }
}