<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TicketType>
 */
class TicketTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => Event::all()->random()->id,
            'title' => fake()->randomElement(array('vip', 'classic', 'regular')),
            'slug' => fake()->slug(),
            'description' => fake()->text(100),
            'available_tickets' => rand(50, 100),
            'price' => rand(2500, 1500),
            'currency_id' => Currency::all()->random()->id,
        ];
    }
}
