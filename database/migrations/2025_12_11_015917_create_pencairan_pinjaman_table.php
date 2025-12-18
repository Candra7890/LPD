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
        Schema::create('pencairan_pinjaman', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pencairan');
            $table->UnsignedInteger('pengajuan_pinjaman_id');
            $table->UnsignedInteger('pinjaman_aktif_id');
            $table->UnsignedInteger('pengguna_id');
            $table->date('tanggal_pencairan')->nullable();
            $table->string('jumlah_disetujui');
            $table->string('potongan_biaya');
            $table->string('jumlah_diterima');
            $table->string('potongan_provisi');
            $table->string('potongan_admin');
            $table->integer('metode_pencairan')->nullable()->comment('1 = transfer, 2 = tunai');
            $table->string('bank_tujuan')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->string('nama_rekening')->nullable();
            $table->integer('status')->nullable()->comment('1 = selesai, 0 = proses pencairan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pencairan_pinjaman');
    }
};