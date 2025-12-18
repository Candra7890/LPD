<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use App\Models\Pekerjaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class NasabahController extends Controller
{
    public function index()
    {
        $nasabah = Nasabah::with('pekerjaan')->orderBy('created_at', 'desc')->get();
        $pekerjaan = Pekerjaan::orderBy('nama_pekerjaan', 'asc')->get();
        return view('teller.nasabah.manajemen-nasabah', compact('nasabah', 'pekerjaan'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16|unique:nasabah,nik',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'pekerjaan' => 'required|integer',
            'status_perkawinan' => 'required|in:belum_kawin,kawin,cerai',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'no_telepon.required' => 'No. telepon wajib diisi',
            'pekerjaan.required' => 'Pekerjaan wajib diisi',
            'status_perkawinan.required' => 'Status perkawinan wajib dipilih',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format foto harus JPG, JPEG, atau PNG',
            'foto.max' => 'Ukuran foto maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $kodeNasabah = $this->generateKodeNasabah();

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = 'nasabah_' . time() . '.' . $file->getClientOriginalExtension();
            $fotoPath = $file->storeAs('nasabah', $filename, 'public');
        }

        Nasabah::create([
            'kode_nasabah' => $kodeNasabah,
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'pekerjaan' => $request->pekerjaan,
            'status_perkawinan' => $request->status_perkawinan,
            'foto' => $fotoPath,
            'is_active' => 1,
        ]);

        return redirect()->route('teller.nasabah.index')
            ->with('success', 'Data nasabah berhasil ditambahkan dengan kode: ' . $kodeNasabah);
    }

    public function show($id)
    {
        $nasabah = Nasabah::findOrFail($id);
        
        $html = '
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="' . ($nasabah->foto ? asset('storage/' . $nasabah->foto) : asset('assets/images/default-avatar.png')) . '" 
                         class="img-fluid rounded mb-3" style="max-height: 200px;">
                    <h5>' . $nasabah->nama_lengkap . '</h5>
                    <p class="text-muted">' . $nasabah->kode_nasabah . '</p>
                    <span class="badge badge-' . ($nasabah->is_active ? 'success' : 'danger') . '">
                        ' . ($nasabah->is_active ? 'Aktif' : 'Non-Aktif') . '
                    </span>
                </div>
                <div class="col-md-8">
                    <h6 class="text-primary"><i class="fa fa-user"></i> Data Identitas</h6>
                    <table class="table table-sm">
                        <tr>
                            <td width="40%"><strong>NIK</strong></td>
                            <td>' . $nasabah->nik . '</td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Kelamin</strong></td>
                            <td>' . ($nasabah->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan') . '</td>
                        </tr>
                        <tr>
                            <td><strong>Tempat, Tanggal Lahir</strong></td>
                            <td>' . $nasabah->tempat_lahir . ', ' . date('d F Y', strtotime($nasabah->tanggal_lahir)) . '</td>
                        </tr>
                        <tr>
                            <td><strong>Status Perkawinan</strong></td>
                            <td>' . ucwords(str_replace('_', ' ', $nasabah->status_perkawinan)) . '</td>
                        </tr>
                    </table>
                    
                    <h6 class="text-primary mt-3"><i class="fa fa-address-book"></i> Data Kontak</h6>
                    <table class="table table-sm">
                        <tr>
                            <td width="40%"><strong>Alamat</strong></td>
                            <td>' . $nasabah->alamat . '</td>
                        </tr>
                        <tr>
                            <td><strong>No. Telepon</strong></td>
                            <td>' . $nasabah->no_telepon . '</td>
                        </tr>
                        <tr>
                            <td><strong>Pekerjaan</strong></td>
                            <td>' . $nasabah->pekerjaan . '</td>
                        </tr>
                    </table>
                </div>
            </div>
        ';
        
        return response($html);
    }

    public function edit($id)
    {
        $nasabah = Nasabah::findOrFail($id);
        
        $html = '
            <h6 class="text-primary"><i class="fa fa-user"></i> Data Identitas</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>NIK <span class="text-danger">*</span></label>
                        <input type="text" name="nik" class="form-control" maxlength="16" value="' . $nasabah->nik . '" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lengkap" class="form-control" value="' . $nasabah->nama_lengkap . '" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jenis_kelamin" class="form-control" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L" ' . ($nasabah->jenis_kelamin == 'L' ? 'selected' : '') . '>Laki-laki</option>
                            <option value="P" ' . ($nasabah->jenis_kelamin == 'P' ? 'selected' : '') . '>Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status Perkawinan <span class="text-danger">*</span></label>
                        <select name="status_perkawinan" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="belum_kawin" ' . ($nasabah->status_perkawinan == 'belum_kawin' ? 'selected' : '') . '>Belum Kawin</option>
                            <option value="kawin" ' . ($nasabah->status_perkawinan == 'kawin' ? 'selected' : '') . '>Kawin</option>
                            <option value="cerai" ' . ($nasabah->status_perkawinan == 'cerai' ? 'selected' : '') . '>Cerai</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tempat Lahir <span class="text-danger">*</span></label>
                        <input type="text" name="tempat_lahir" class="form-control" value="' . $nasabah->tempat_lahir . '" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tanggal Lahir <span class="text-danger">*</span></label>
                        <input type="date" name="tanggal_lahir" class="form-control" value="' . $nasabah->tanggal_lahir . '" required>
                    </div>
                </div>
            </div>

            <hr>
            <h6 class="text-primary"><i class="fa fa-address-book"></i> Data Kontak</h6>
            <div class="form-group">
                <label>Alamat <span class="text-danger">*</span></label>
                <textarea name="alamat" class="form-control" rows="3" required>' . $nasabah->alamat . '</textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>No. Telepon <span class="text-danger">*</span></label>
                        <input type="text" name="no_telepon" class="form-control" maxlength="15" value="' . $nasabah->no_telepon . '" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Pekerjaan <span class="text-danger">*</span></label>
                        <input type="text" name="pekerjaan" class="form-control" value="' . $nasabah->pekerjaan . '" required>
                    </div>
                </div>
            </div>

            <hr>
            <h6 class="text-primary"><i class="fa fa-image"></i> Foto Nasabah</h6>
            ' . ($nasabah->foto ? '<div class="mb-2"><img src="' . asset('storage/' . $nasabah->foto) . '" class="img-thumbnail" style="max-height: 150px;"></div>' : '') . '
            <div class="form-group">
                <label>Upload Foto Baru</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
                <small class="text-muted">Format: JPG, PNG, max 2MB. Kosongkan jika tidak ingin mengubah foto.</small>
            </div>

            <hr>
            <h6 class="text-primary"><i class="fa fa-cog"></i> Status</h6>
            <div class="form-group">
                <label>Status Nasabah <span class="text-danger">*</span></label>
                <select name="is_active" class="form-control" required>
                    <option value="1" ' . ($nasabah->is_active == 1 ? 'selected' : '') . '>Aktif</option>
                    <option value="0" ' . ($nasabah->is_active == 0 ? 'selected' : '') . '>Non-Aktif</option>
                </select>
            </div>
        ';
        
        return response($html);
    }

    public function update(Request $request, $id)
    {
        $nasabah = Nasabah::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16|unique:nasabah,nik,' . $id,
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:15',
            'pekerjaan' => 'required|integer',
            'status_perkawinan' => 'required|in:belum_kawin,kawin,cerai',
            'is_active' => 'required|in:0,1',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'nik.required' => 'NIK wajib diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah terdaftar',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format foto harus JPG, JPEG, atau PNG',
            'foto.max' => 'Ukuran foto maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'pekerjaan' => $request->pekerjaan,
            'status_perkawinan' => $request->status_perkawinan,
            'is_active' => $request->is_active,
        ];

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($nasabah->foto && Storage::disk('public')->exists($nasabah->foto)) {
                Storage::disk('public')->delete($nasabah->foto);
            }
            
            $file = $request->file('foto');
            $filename = 'nasabah_' . time() . '.' . $file->getClientOriginalExtension();
            $fotoPath = $file->storeAs('nasabah', $filename, 'public');
            $data['foto'] = $fotoPath;
        }

        $nasabah->update($data);

        return redirect()->route('teller.nasabah.index')
            ->with('success', 'Data nasabah berhasil diupdate');
    }

    public function destroy($id)
    {
        $nasabah = Nasabah::findOrFail($id);
        
        // Hapus foto jika ada
        if ($nasabah->foto && Storage::disk('public')->exists($nasabah->foto)) {
            Storage::disk('public')->delete($nasabah->foto);
        }
        
        $nasabah->delete();

        return redirect()->route('teller.nasabah.index')
            ->with('success', 'Data nasabah berhasil dihapus');
    }

    private function generateKodeNasabah()
    {
        $prefix = 'NSB';
        $year = date('Y');
        $month = date('m');
        
        $lastNasabah = Nasabah::where('kode_nasabah', 'like', $prefix . $year . $month . '%')
            ->orderBy('kode_nasabah', 'desc')
            ->first();
        
        if ($lastNasabah) {
            $lastNumber = intval(substr($lastNasabah->kode_nasabah, -4));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . $year . $month . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }
}