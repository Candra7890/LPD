<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PekerjaanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pekerjaan')->insert([
            ['nama_pekerjaan' => 'Tidak Bekerja', 'created_at' => now(), 'updated_at' => now()],
            ['nama_pekerjaan' => 'Pelajar / Mahasiswa', 'created_at' => now(), 'updated_at' => now()],
            ['nama_pekerjaan' => 'Pegawai Negeri', 'created_at' => now(), 'updated_at' => now()],
            ['nama_pekerjaan' => 'Pegawai Swasta', 'created_at' => now(), 'updated_at' => now()],
            ['nama_pekerjaan' => 'Wirausaha', 'created_at' => now(), 'updated_at' => now()],
            ['nama_pekerjaan' => 'Petani', 'created_at' => now(), 'updated_at' => now()],
            ['nama_pekerjaan' => 'Pedagang', 'created_at' => now(), 'updated_at' => now()],
            ['nama_pekerjaan' => 'Nelayan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_pekerjaan' => 'Pensiunan', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
