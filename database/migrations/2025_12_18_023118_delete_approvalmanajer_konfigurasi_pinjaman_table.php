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
            $table->dropColumn('plafon_approval_manajer_minimum');
            $table->dropColumn('wajib_approval_manajer');
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
            $table->string('plafon_approval_manajer_minimum')->nullable();
            $table->integer('wajib_approval_manajer')->nullable();
        });
    }
};