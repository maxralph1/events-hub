<?php

namespace Database\Factories;

use App\Models\EventHall;
use App\Models\Host;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_hall_id' => EventHall::all()->random()->id,
            'host_id' => Host::all()->random()->id,
            'user_id' => User::all()->random()->id,
            // 'user_id' => User::where('role_id', Role::where('title', 'super-admin')->first()->id)->first(),
            'title' => fake()->text(20),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->text(100),
            'start_date' => fake()->date(now()->addDays(rand(1, 10))->toDateString()),
            'start_time' => fake()->time(),
            'end_date' => fake()->date(now()->addDays(rand(20, 40))->toDateString()),
            'end_time' => fake()->time(),
            'age_limit' => rand(13, 18),
        ];
    }
}
