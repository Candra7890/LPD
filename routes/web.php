<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JenisPinjamanController;
use App\Http\Controllers\PinjamanController;
use App\Http\Controllers\PengajuanPinjamanController;
use App\Http\Controllers\KonfigurasiPinjamanController;
use App\Http\Controllers\JenisSimpananController;
use App\Http\Controllers\SimpananController;
use App\Http\Controllers\KonfigurasiSimpananController;
use App\Http\Controllers\AgunanController;
use App\Http\Controllers\NasabahController;
use App\Http\Controllers\PencairanPinjamanController;
use App\Http\Controllers\PinjamanAktifController;
use App\Http\Controllers\PembayaranAngsuranController;
use App\Http\Controllers\TunggakanPinjamanController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\RiwayatPinjamanController;
use App\Http\Controllers\ManajemenPegawaiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Guest routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Teller routes (hanya untuk role teller)
    Route::middleware(['check.role:teller'])->prefix('teller')->name('teller.')->group(function () {
        // Nasabah Management
        Route::get('/nasabah', [NasabahController::class, 'index'])->name('nasabah.index');
        Route::post('/nasabah', [NasabahController::class, 'store'])->name('nasabah.store');
        Route::get('/nasabah/{id}', [NasabahController::class, 'show'])->name('nasabah.show');
        Route::get('/nasabah/{id}/edit', [NasabahController::class, 'edit'])->name('nasabah.edit');
        Route::put('/nasabah/{id}', [NasabahController::class, 'update'])->name('nasabah.update');
        Route::delete('/nasabah/{id}', [NasabahController::class, 'destroy'])->name('nasabah.destroy');

        // Pengajuan Pinjaman
        Route::prefix('pengajuan-pinjaman')->name('pengajuan-pinjaman.')->group(function () {
            Route::get('/', [PengajuanPinjamanController::class, 'index'])->name('index');
            Route::get('/create', [PengajuanPinjamanController::class, 'create'])->name('create');
            Route::post('/', [PengajuanPinjamanController::class, 'store'])->name('store');
            Route::get('/{id}', [PengajuanPinjamanController::class, 'show'])->name('show');
            Route::get('/konfigurasi/{id}', [PengajuanPinjamanController::class, 'getKonfigurasi'])->name('konfigurasi');
            Route::post('/kalkulasi', [PengajuanPinjamanController::class, 'kalkulasi'])->name('kalkulasi');
            Route::put('/{id}/approve', [PengajuanPinjamanController::class, 'approve'])->name('approve');
            Route::put('/{id}/reject', [PengajuanPinjamanController::class, 'reject'])->name('reject');
        });

        // Agunan
        Route::prefix('agunan')->name('agunan.')->group(function () {
            Route::get('/create/{pengajuanId}', [AgunanController::class, 'create'])->name('create');
            Route::post('/', [AgunanController::class, 'store'])->name('store');
            Route::get('/{id}', [AgunanController::class, 'show'])->name('show');
            Route::put('/{id}/approve', [AgunanController::class, 'approve'])->name('approve');
            Route::put('/{id}/reject', [AgunanController::class, 'reject'])->name('reject');
        });

        // Pencairan Pinjaman
        Route::prefix('pencairan-pinjaman')->name('pencairan-pinjaman.')->group(function () {
            Route::get('/', [PencairanPinjamanController::class, 'index'])->name('index');
            Route::get('/{id}/pengajuan', [PencairanPinjamanController::class, 'showPengajuan'])->name('showPengajuan');
            Route::get('/{pengajuanId}/create', [PencairanPinjamanController::class, 'create'])->name('create');
            Route::post('/{pengajuanId}', [PencairanPinjamanController::class, 'store'])->name('store');
            Route::get('/{id}/show', [PencairanPinjamanController::class, 'show'])->name('show');
        });

        // Pinjaman Aktif
        Route::prefix('pinjaman-aktif')->name('pinjaman-aktif.')->group(function () {
            Route::get('/', [PinjamanAktifController::class, 'index'])->name('index');
            Route::get('/{id}', [PinjamanAktifController::class, 'show'])->name('show');
            Route::get('/{id}/jadwal', [PinjamanAktifController::class, 'jadwalAngsuran'])->name('jadwal');
        });

        // Riwayat Pinjaman (BARU)
        Route::prefix('riwayat-pinjaman')->name('riwayat-pinjaman.')->group(function () {
            Route::get('/', [RiwayatPinjamanController::class, 'index'])->name('index');
            Route::get('/{id}', [RiwayatPinjamanController::class, 'show'])->name('show');
        });

        // Pembayaran Angsuran
        Route::prefix('pembayaran-angsuran')->name('pembayaran-angsuran.')->group(function () {
            Route::get('/{pinjamanAktifId}/create', [PembayaranAngsuranController::class, 'create'])->name('create');
            Route::post('/{pinjamanAktifId}', [PembayaranAngsuranController::class, 'store'])->name('store');
            Route::get('/{pinjamanAktifId}/history', [PembayaranAngsuranController::class, 'history'])->name('history');
        });

        // Tunggakan Pinjaman
        Route::prefix('tunggakan-pinjaman')->name('tunggakan-pinjaman.')->group(function () {
            Route::get('/', [TunggakanPinjamanController::class, 'index'])->name('index');
            Route::get('/{id}', [TunggakanPinjamanController::class, 'show'])->name('show');
            Route::post('/{id}/sita-agunan', [TunggakanPinjamanController::class, 'sitaAgunan'])->name('sita-agunan');
        });

        // Denda Checker
        Route::prefix('denda-checker')->name('denda-checker.')->group(function () {
            Route::post('/check', [DendaController::class, 'checkAndUpdateDenda'])->name('check');
            Route::get('/preview', [DendaController::class, 'previewDenda'])->name('preview');
        });
    });

    // Manajer routes
    Route::middleware(['check.role:manajer'])->prefix('manajer')->name('manajer.')->group(function () {
        // Jenis Pinjaman
        Route::get('/pinjaman/jenis-pinjaman', [JenisPinjamanController::class, 'index'])->name('jenis-pinjaman.index');
        Route::post('/pinjaman/jenis-pinjaman', [JenisPinjamanController::class, 'store'])->name('jenis-pinjaman.store');
        Route::put('/pinjaman/jenis-pinjaman/{id}', [JenisPinjamanController::class, 'update'])->name('jenis-pinjaman.update');
        Route::delete('/pinjaman/jenis-pinjaman/{id}', [JenisPinjamanController::class, 'destroy'])->name('jenis-pinjaman.destroy');
        
        // Produk Pinjaman
        Route::get('/pinjaman/produk', [PinjamanController::class, 'index'])->name('pinjaman.index');
        Route::post('/pinjaman/produk', [PinjamanController::class, 'store'])->name('pinjaman.store');
        Route::put('/pinjaman/produk/{id}', [PinjamanController::class, 'update'])->name('pinjaman.update');
        Route::delete('/pinjaman/produk/{id}', [PinjamanController::class, 'destroy'])->name('pinjaman.destroy');
        
        // Konfigurasi Pinjaman
        Route::get('/pinjaman/konfigurasi', [KonfigurasiPinjamanController::class, 'index'])->name('konfigurasi-pinjaman.index');
        Route::post('/pinjaman/konfigurasi', [KonfigurasiPinjamanController::class, 'store'])->name('konfigurasi-pinjaman.store');
        Route::put('/pinjaman/konfigurasi/{id}', [KonfigurasiPinjamanController::class, 'update'])->name('konfigurasi-pinjaman.update');
        Route::delete('/pinjaman/konfigurasi/{id}', [KonfigurasiPinjamanController::class, 'destroy'])->name('konfigurasi-pinjaman.destroy');

        // User Pegawai Management
        Route::prefix('manajemen-pegawai')->name('manajemen-pegawai.')->group(function () {
            Route::get('/', [ManajemenPegawaiController::class, 'index'])->name('index');
            Route::post('/', [ManajemenPegawaiController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ManajemenPegawaiController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ManajemenPegawaiController::class, 'update'])->name('update');
            Route::delete('/{id}', [ManajemenPegawaiController::class, 'destroy'])->name('destroy');
        });
    });
    
});