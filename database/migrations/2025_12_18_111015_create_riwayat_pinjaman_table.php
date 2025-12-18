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
        Schema::create('riwayat_pinjaman', function (Blueprint $table) {
            $table->id();
            $table->UnsignedInteger('pinjaman_aktif_id');
            $table->UnsignedInteger('pengguna_id');
            $table->UnsignedInteger('pinjaman_id');
            $table->string('nomor_pinjaman');
            $table->string('pokok_pinjaman');
            $table->integer('tenor');
            $table->date('tanggal_pencairan');
            $table->date('tanggal_pelunasan');
            $table->string('total_dibayar');
            $table->string('total_pokok_dibayar');
            $table->string('total_bunga_dibayar');
            $table->string('total_denda_dibayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_angsuran');
    }
};