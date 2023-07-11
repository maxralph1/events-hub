<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\Event;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
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
            'ticket_type_id' => TicketType::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'ticket_number' => Str::uuid()->getHex(),
            // 'ticket_number' => fake()->uuid(),
            // 'amount_paid' => rand(2500, 1500),
            // 'amount_paid' => fake()->numberBetween($min = 100, $max = 900),
            'amount_paid' => fake()->randomFloat(2, 10, 999),
            'currency_id' => Currency::all()->random()->id,
            'payment_confirmed' => fake()->boolean(),
        ];
    }
}
