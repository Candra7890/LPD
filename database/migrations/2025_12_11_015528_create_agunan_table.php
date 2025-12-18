<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('agunan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_agunan');
            $table->UnsignedInteger('pengajuan_pinjaman_id');
            $table->UnsignedInteger('pinjaman_aktif_id')->nullable();
            $table->string('nama_agunan');
            $table->string('deskripsi')->nullable();
            $table->string('nilai_pasar');
            $table->string('nilai_penjaminan');
            $table->integer('status_kepemilikan')->comment('1 = pribadi, 2 = keluarga, 3 = perusahaan');
            $table->string('nama_pemilik');
            $table->string('alamat_agunan')->nullable();
            $table->string('file_agunan')->nullable();
            $table->date('tanggal_pengikatan')->nullable();
            $table->date('tanggal_pelepasan')->nullable();
            $table->string('lokasi_agunan_tersimpan');
            $table->date('tanggal_penyitaan')->nullable();
            $table->string('alasan_penyitaan')->nullable();
            $table->integer('status')->comment('1 = diterima, 2 = ditolak, 3 = pengajuan, 4 = aktif, 5 = dilepaskan, 6 = disita');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agunan');
    }
};