<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('konfigurasi_pinjaman', function (Blueprint $table) {
            $table->dropColumn('metode_bunga');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('konfigurasi_pinjaman', function (Blueprint $table) {
            $table->integer('metode_bunga')->nullable()->comment('1 = flat, 2 = efektif, 3 = anuitas');
        });
    }
};