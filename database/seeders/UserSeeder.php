<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Manajer
        User::create([
            'name' => 'Manajer LPD',
            'email' => 'manajer@lpd.com',
            'password' => Hash::make('password'),
            'role' => 2, // Manajer
            'is_active' => 1,
        ]);

        // Create Teller
        User::create([
            'name' => 'Teller LPD',
            'email' => 'teller@lpd.com',
            'password' => Hash::make('password'),
            'role' => 1, // Teller
            'is_active' => 1,
        ]);

        // Create Nasabah
        User::create([
            'name' => 'Nasabah Demo',
            'email' => 'nasabah@lpd.com',
            'password' => Hash::make('password'),
            'role' => 3, // Nasabah
            'is_active' => 1,
        ]);

        echo "Users created successfully!\n";
        echo "Manajer: manajer@lpd.com / password\n";
        echo "Teller: teller@lpd.com / password\n";
        echo "Nasabah: nasabah@lpd.com / password\n";
    }
}