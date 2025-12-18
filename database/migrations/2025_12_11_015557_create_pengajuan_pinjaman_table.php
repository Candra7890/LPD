<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pengajuan_pinjaman', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_pengajuan');
            $table->UnsignedInteger('pengguna_id');
            $table->UnsignedInteger('pinjaman_id');
            $table->string('jumlah_pengajuan');
            $table->string('jumlah_disetujui');
            $table->date('tanggal_pencairan');
            $table->date('tanggal_pengajuan');
            $table->string('total_angsuran');
            $table->string('total_bunga');
            $table->string('total_kewajiban');
            $table->string('biaya_provisi');
            $table->string('biaya_administrasi');
            $table->string('biaya_asuransi');
            $table->string('total_biaya');
            $table->integer('status_approval_teller')->nullable()->comment('1 = disetujui, 2 = ditolak');
            $table->string('catatan_pengajuan_teller')->nullable();
            $table->integer('status_approval_manajer')->nullable()->comment('1 = disetujui, 2 = ditolak');
            $table->string('catatan_pengajuan_manajer')->nullable();
            $table->integer('status')->nullable()->comment('0 = Pengajuan (Draft), 1 = Disetujui Teller, 2 = Ditolak Teller, 3 = Dicairkan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengajuan_pinjaman');
    }
};