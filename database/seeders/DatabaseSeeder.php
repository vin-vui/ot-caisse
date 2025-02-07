<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Mia G.',
            'email' => 'mgouget@protonmail.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Véronique',
            'email' => 'info@ot-paysbaumois.fr',
            'password' => Hash::make('oRviuneBw23*'),
        ]);
    }
}
