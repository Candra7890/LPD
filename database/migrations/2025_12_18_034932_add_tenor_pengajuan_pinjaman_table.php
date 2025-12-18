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
        Schema::table('pengajuan_pinjaman', function (Blueprint $table) {
            $table->string('jumlah_disetujui')->nullable()->change();
            $table->date('tanggal_pencairan')->nullable()->change();

            $table->integer('tenor')->after('jumlah_disetujui');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengajuan_pinjaman', function (Blueprint $table) {
            $table->string('jumlah_disetujui')->nullable(false)->change();
            $table->date('tanggal_pencairan')->nullable(false)->change();

            $table->dropColumn('tenor');
        });
    }
};
