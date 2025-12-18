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
        Schema::create('jadwal_angsuran', function (Blueprint $table) {
            $table->id();
            $table->UnsignedInteger('pinjaman_aktif_id');
            $table->UnsignedInteger('pengguna_id');
            $table->integer('angsuran_ke');
            $table->date('tanggal_jatuh_tempo');
            $table->string('saldo_awal')->comment('Saldo pokok di awal periode');
            $table->string('angsuran_pokok');
            $table->string('angsuran_bunga');
            $table->string('total_angsuran');
            $table->string('saldo_akhir')->comment('Saldo pokok setelah angsuran dibayar');
            $table->integer('status')->default(0)->comment('0 = belum bayar, 1 = bayar sebagian, 2 = lunas, 3 = menunggak');
            $table->date('tanggal_bayar')->nullable();
            $table->string('jumlah_terbayar')->default('0')->comment('Total yang sudah dibayar');
            $table->string('pokok_terbayar')->default('0')->comment('Pokok yang sudah dibayar');
            $table->string('bunga_terbayar')->default('0')->comment('Bunga yang sudah dibayar');
            $table->string('sisa_belum_terbayar')->comment('Sisa yang belum dibayar');
            $table->integer('hari_keterlambatan')->default(0)->comment('Jumlah hari terlambat dari jatuh tempo');
            $table->string('denda')->default('0');
            $table->string('denda_terbayar')->default('0');
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