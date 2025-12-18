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
        Schema::create('pinjaman_aktif', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pinjaman');
            $table->UnsignedInteger('pengajuan_pinjaman_id');
            $table->UnsignedInteger('pengguna_id');
            $table->UnsignedInteger('pinjaman_id');
            $table->string('pokok_pinjaman');
            $table->string('sisa_pokok');
            $table->integer('tenor_bulan')->nullable();
            $table->integer('sisa_tenor')->nullable();
            $table->string('suku_bunga');
            $table->integer('metode_bunga')->nullable()->comment('1 = flat, 2 = efektif, 3 = anuitas');
            $table->date('tanggal_pencairan')->nullable();
            $table->date('tanggal_jatuh_tempo_pertama')->nullable();
            $table->date('tanggal_jatuh_tempo_berikutnya')->nullable();
            $table->string('angsuran_per_bulan');
            $table->string('total_bunga');
            $table->string('total_kewajiban');
            $table->string('total_dibayar');
            $table->string('total_pokok_dibayar');
            $table->string('total_bunga_dibayar');
            $table->string('total_denda');
            $table->string('denda_terbayar');
            $table->string('denda_belum_terbayar');
            $table->integer('hari_tunggakan')->nullable();
            $table->date('tanggal_pelunasan')->nullable();
            $table->integer('status')->nullable()->comment('1 = aktif, 2 = menunggak, 3 = lunas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjaman_aktif');
    }
};