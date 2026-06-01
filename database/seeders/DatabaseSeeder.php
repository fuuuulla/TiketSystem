<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crée l'admin
        User::firstOrCreate(
            ['email' => 'boudoumifella@gmail.com'],
            [
                'name'     => 'Admin',
                'email'    => 'boudoumifella@gmail.com',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        // Crée les packs d'hébergement
        $this->call([
            HostingSeeder::class,
        ]);
    }
}