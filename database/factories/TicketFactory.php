<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ticket;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'hosting_id' => \App\Models\Hosting::factory(),
            'nom_complet' => $this->faker->name(),
            'telephone' => $this->faker->phoneNumber(),
            'adresse' => $this->faker->address(),
            'societe' => $this->faker->optional()->company(),
            'statut' => $this->faker->randomElement(['pending', 'validated', 'canceled']),
        ];
    }
}