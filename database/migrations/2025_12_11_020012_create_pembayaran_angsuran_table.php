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
        Schema::create('pembayaran_angsuran', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pembayaran')->unique();
            $table->UnsignedInteger('pinjaman_aktif_id');
            $table->UnsignedInteger('jadwal_angsuran_id');
            $table->UnsignedInteger('pengguna_id');
            $table->date('tanggal_pembayaran');
            $table->date('tanggal_transaksi');
            $table->string('jumlah_pembayaran');
            $table->string('pembayaran_pokok')->default('0');
            $table->string('pembayaran_bunga')->default('0');
            $table->string('pembayaran_denda')->default('0');
            $table->string('sisa_pokok');
            $table->string('sisa_kewajiban');
            $table->integer('metode_pembayaran')->comment('1 = tunai, 2 = transfer, 3 = auto debet, 4 = virtual account');
            $table->string('referensi_pembayaran')->nullable()->comment('Nomor referensi bank/payment gateway');
            $table->text('keterangan')->nullable();
            $table->integer('status')->default(1)->comment('1 = berhasil, 2 = pending, 3 = gagal, 4 = dibatalkan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_angsuran');
    }
};