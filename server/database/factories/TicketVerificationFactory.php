<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TicketVerification>
 */
class TicketVerificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::all()->random()->id,
            // 'user_id' => User::all()->random()->id,
            'user_id' => User::where('role_id', Role::where('title', 'admin')->first()->id)->first(),
            'payment_confirmed' => fake()->boolean(),
        ];
    }
}
