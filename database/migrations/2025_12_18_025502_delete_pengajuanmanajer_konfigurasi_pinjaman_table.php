<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            ALTER TABLE pengajuan_pinjaman 
            MODIFY status TINYINT NOT NULL 
            COMMENT '0 = pengajuan, 1 = disetujui teller, 2 = ditolak teller, 3 = dicairkan'
        ");

        DB::statement("
            ALTER TABLE pengajuan_pinjaman
            DROP COLUMN status_approval_manajer,
            DROP COLUMN catatan_pengajuan_manajer
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("
            ALTER TABLE pengajuan_pinjaman 
            MODIFY status TINYINT NOT NULL 
            COMMENT '0 = Pengajuan (Draft), 1 = Disetujui Teller, 2 = Ditolak Teller, 3 = Disetujui Manajer, 4 = Ditolak Manajer, 5 = Dicairkan'
        ");

        DB::statement("
            ALTER TABLE pengajuan_pinjaman
            ADD status_approval_manajer INT NULL,
            ADD catatan_pengajuan_manajer STRING NULL
        ");
    }
};
