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
        Schema::create('konfigurasi_pinjaman', function (Blueprint $table) {
            $table->id();
            $table->UnsignedInteger('pinjaman_id');
            $table->string('plafon_minimum', 50)->nullable();
            $table->string('plafon_maksimum', 50)->nullable();
            $table->string('tenor_minimum', 20)->nullable();
            $table->string('tenor_maksimum', 20)->nullable();
            $table->string('sukubunga_minimum', 20)->nullable();
            $table->integer('metode_bunga')->nullable()->comment('1 = flat, 2 = efektif, 3 = anuitas');
            $table->string('persentase_provisi', 20)->nullable();
            $table->string('persentase_administrasi', 20)->nullable();
            $table->string('persentase_asuransi', 20)->nullable();
            $table->integer('biaya_meterai');
            $table->string('persentase_denda_harian', 20)->nullable();
            $table->string('persentase_denda_bulanan', 20)->nullable();
            $table->string('denda_maksimal', 50)->nullable();
            $table->integer('toleransi_periode_denda')->nullable();
            $table->integer('pelunasandipercepat')->default(0)->comment('1 = boleh pelunasan dipercepat, 0 = tidak boleh');
            $table->string('persentase_pinalti_pelunasan', 20)->nullable();
            $table->string('plafon_approval_manajer_minimum', 255)->nullable();
            $table->integer('wajib_approval_manajer')->nullable();
            $table->integer('wajib_agunan')->default(0)->comment('1 = perlu agunan, 0 = tidak perlu agunan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konfigurasi_pinjaman');
    }
};