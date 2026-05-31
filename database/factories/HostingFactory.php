<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Hosting;

class HostingFactory extends Factory
{
    protected $model = Hosting::class;

    public function definition(): array
    {
        return [
            'nom' => $this->faker->word() . ' ' . $this->faker->randomElement(['Standard', 'Premium', 'Pro', 'Basic']),
            'prix' => $this->faker->numberBetween(1000, 50000),
            'duree' => $this->faker->randomElement(['1 mois', '3 mois', '6 mois', '1 an', '2 ans']),
        ];
    }
}