<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Currency;
use App\Models\Event;
use App\Models\Role;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketTypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_super_admin_can_retrieve_ticket_types()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $response = $this->actingAs($superAdmin)->getJson('/api/v1/super-admin/ticket-types');
        $response2 = $this->actingAs($admin)->getJson('/api/v1/super-admin/ticket-types');
        $response3 = $this->actingAs($genericUser)->getJson('/api/v1/super-admin/ticket-types');

        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(10, 'data');
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_create_ticket_type()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $response = $this->actingAs($superAdmin)->postJson('/api/v1/super-admin/ticket-types', [
            'event_id' => Event::all()->random()->id,
            'title' => 'Chicken Festivale',
            // 'slug' => fake()->slug(),
            'description' => 'This is a Chicken Festivale',
            'available_tickets' => 3000000,
            'price' => rand(2500, 1500),
            'currency_id' => Currency::all()->random()->id,
        ]);
        $response2 = $this->actingAs($admin)->postJson('/api/v1/super-admin/ticket-types', [
            'event_id' => Event::all()->random()->id,
            'title' => fake()->randomElement(array('vip', 'classic', 'regular')),
            // 'slug' => fake()->slug(),
            'description' => fake()->text(100),
            'available_tickets' => rand(50, 100),
            'price' => rand(2500, 1500),
            'currency_id' => Currency::all()->random()->id,
        ]);
        $response3 = $this->actingAs($genericUser)->postJson('/api/v1/super-admin/ticket-types', [
            'event_id' => Event::all()->random()->id,
            'title' => fake()->randomElement(array('vip', 'classic', 'regular')),
            // 'slug' => fake()->slug(),
            'description' => fake()->text(100),
            'available_tickets' => rand(50, 100),
            'price' => rand(2500, 1500),
            'currency_id' => Currency::all()->random()->id,
        ]);

        $response->assertStatus(201)
            ->assertJsonCount(11, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'available_tickets'],
            ])
            ->assertJsonPath('data.available_tickets', 3000000);

        $this->assertDatabaseHas('ticket_types', [
            'available_tickets' => 3000000,
        ]);
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_view_ticket_type()
    {
        $ticketType = TicketType::factory()->create();

        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $response = $this->actingAs($superAdmin)->getJson('/api/v1/super-admin/ticket-types/' . $ticketType->id);
        $response2 = $this->actingAs($admin)->getJson('/api/v1/super-admin/ticket-types/' . $ticketType->id);
        $response3 = $this->actingAs($genericUser)->getJson('/api/v1/super-admin/ticket-types/' . $ticketType->id);

        $response->assertStatus(200)
            ->assertJsonCount(11, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'available_tickets'],
            ]);
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_update_ticket_type()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $ticketType = TicketType::factory()->create();

        $response = $this->actingAs($superAdmin)->putJson('/api/v1/super-admin/ticket-types/' . $ticketType->id, [
            'available_tickets' => 5000,
        ]);

        $response2 = $this->actingAs($admin)->putJson('/api/v1/super-admin/ticket-types/' . $ticketType->id, [
            'available_tickets' => 5000,
        ]);

        $response3 = $this->actingAs($genericUser)->putJson('/api/v1/super-admin/ticket-types/' . $ticketType->id, [
            'available_tickets' => 5000,
        ]);

        $response->assertStatus(200)
            ->assertJsonCount(11, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'available_tickets'],
            ])
            ->assertJsonPath('data.available_tickets', 5000);

        $this->assertDatabaseHas('ticket_types', [
            'available_tickets' => 5000,
        ]);
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_delete_ticket_type()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $ticketType = TicketType::factory()->create();
        $ticketType2 = TicketType::factory()->create();
        $ticketType3 = TicketType::factory()->create();

        $response = $this->actingAs($superAdmin)->deleteJson('/api/v1/super-admin/ticket-types/' . $ticketType->id);
        $response2 = $this->actingAs($admin)->deleteJson('/api/v1/super-admin/ticket-types/' . $ticketType2->id);
        $response3 = $this->actingAs($genericUser)->deleteJson('/api/v1/super-admin/ticket-types/' . $ticketType3->id);

        $response->assertNoContent();

        $this->assertDatabaseHas('ticket_types', [
            'id' => $ticketType->id,
            'deleted_at' => $ticketType->updated_at,       // consider ignoring this line as the 'deleted_at' may differ from the 'updated_at' field by 1 second, thereby causing the test to fail; but will pass if ran again immediately after a failure.
        ])->assertDatabaseCount('ticket_types', 13);

        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }
}
