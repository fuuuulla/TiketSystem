<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hosting;

class HostingSeeder extends Seeder
{
    public function run(): void 
    {
        $hostings = [ 
            [
                'nom' => 'Pack Basic',
                'prix' => 5000.00,
                'duree' => '2 mois',
            ],
            [
                'nom' => 'Pack Pro',
                'prix' => 12000.00,
                'duree' => '6 mois',
            ],
            [
                'nom' => 'Pack Premium',
                'prix' => 20000.00,
                'duree' => '1 an',
            ],
        ];

        foreach ($hostings as $hosting) {
            Hosting::create($hosting);
        }
    }
}