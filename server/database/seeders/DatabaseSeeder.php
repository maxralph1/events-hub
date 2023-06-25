<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CountrySeeder::class,
            CurrencySeeder::class,
            EventHallSeeder::class,
            HostSeeder::class,
            EventSeeder::class,
            TicketTypeSeeder::class,
            TicketSeeder::class,
            TicketVerificationSeeder::class,
            FeedbackSeeder::class,
            NewsletterSeeder::class,
        ]);
    }
}
