<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Currency;
use App\Models\Event;
use App\Models\Role;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_super_admin_and_admin_can_retrieve_all_tickets_by_all_user_roles()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $response = $this->actingAs($superAdmin)->getJson('/api/v1/super-admin/tickets');
        $response2 = $this->actingAs($admin)->getJson('/api/v1/admin/tickets');
        $response3 = $this->actingAs($genericUser)->getJson('/api/v1/super-admin/tickets');

        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(10, 'data');
        $response2->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(10, 'data');
        $response3->assertStatus(403);
    }

    public function test_all_user_roles_can_create_tickets()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $response = $this->actingAs($superAdmin)->postJson('/api/v1/super-admin/tickets', [
            'event_id' => Event::all()->random()->id,
            'ticket_type_id' => TicketType::all()->random()->id,
            'user_id' => $superAdmin->id,
            // 'ticket_number' => Str::uuid()->getHex(),
            'amount_paid' => 13.99,
            'currency_id' => Currency::all()->random()->id,
            'payment_confirmed' => fake()->boolean(),
        ]);
        $response2 = $this->actingAs($admin)->postJson('/api/v1/admin/tickets', [
            'event_id' => Event::all()->random()->id,
            'ticket_type_id' => TicketType::all()->random()->id,
            'user_id' => $admin->id,
            // 'ticket_number' => Str::uuid()->getHex(),
            'amount_paid' => 50.00,
            'currency_id' => Currency::all()->random()->id,
            'payment_confirmed' => fake()->boolean(),
        ]);
        $response3 = $this->actingAs($genericUser)->postJson('/api/v1/user/tickets', [
            'event_id' => Event::all()->random()->id,
            'ticket_type_id' => TicketType::all()->random()->id,
            'user_id' => $genericUser->id,
            // 'ticket_number' => Str::uuid()->getHex(),
            'amount_paid' => 20.20,
            'currency_id' => Currency::all()->random()->id,
            'payment_confirmed' => fake()->boolean(),
        ]);

        $response->assertStatus(201)
            ->assertJsonCount(12, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'amount_paid'],
            ])
            ->assertJsonPath('data.amount_paid', '13.99');

        $this->assertDatabaseHas('tickets', [
            'amount_paid' => 13.99,
        ]);
        $response2->assertStatus(201)
            ->assertJsonCount(12, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'amount_paid'],
            ])
            ->assertJsonPath('data.amount_paid', '50.00');

        $this->assertDatabaseHas('tickets', [
            'amount_paid' => 50.00,
        ]);
        $response3->assertStatus(201)
            ->assertJsonCount(12, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'amount_paid'],
            ])
            ->assertJsonPath('data.amount_paid', '20.20');

        $this->assertDatabaseHas('tickets', [
            'amount_paid' => 20.20,
        ]);
    }

    public function test_only_superadmin_and_admin_can_view_tickets_created_by_all_user_roles()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $ticket1 = Ticket::factory()->create(['user_id' => $genericUser->id]);
        $ticket2 = Ticket::factory()->create(['user_id' => $superAdmin->id]);
        $ticket3 = Ticket::factory()->create(['user_id' => $admin->id]);

        $response = $this->actingAs($superAdmin)->getJson('/api/v1/super-admin/tickets/' . $ticket1->id);
        $response2 = $this->actingAs($admin)->getJson('/api/v1/admin/tickets/' . $ticket2->id);
        $response3 = $this->actingAs($genericUser)->getJson('/api/v1/user/tickets/' . $ticket3->id);

        $response->assertStatus(200)
            ->assertJsonCount(12, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'amount_paid'],
            ]);
        $response2->assertStatus(200)
            ->assertJsonCount(12, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'amount_paid'],
            ]);
        $response3->assertStatus(403);
    }

    public function test_all_user_roles_can_view_tickets()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $ticket1 = Ticket::factory()->create(['user_id' => $genericUser->id]);
        $ticket2 = Ticket::factory()->create(['user_id' => $genericUser->id]);
        $ticket3 = Ticket::factory()->create(['user_id' => $genericUser->id]);

        $response = $this->actingAs($superAdmin)->getJson('/api/v1/super-admin/tickets/' . $ticket1->id);
        $response2 = $this->actingAs($admin)->getJson('/api/v1/admin/tickets/' . $ticket2->id);
        $response3 = $this->actingAs($genericUser)->getJson('/api/v1/user/tickets/' . $ticket3->id);

        $response->assertStatus(200)
            ->assertJsonCount(12, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'amount_paid'],
            ]);
        $response2->assertStatus(200)
            ->assertJsonCount(12, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'amount_paid'],
            ]);
        $response3->assertStatus(200)
            ->assertJsonCount(12, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'amount_paid'],
            ]);
    }

    public function test_only_superadmin_can_update_ticket()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $ticket = Ticket::factory()->create();

        $response = $this->actingAs($superAdmin)->putJson('/api/v1/super-admin/tickets/' . $ticket->id, [
            'amount_paid' => 5000,
        ]);

        $response2 = $this->actingAs($admin)->putJson('/api/v1/super-admin/tickets/' . $ticket->id, [
            'amount_paid' => 5000,
        ]);

        $response3 = $this->actingAs($genericUser)->putJson('/api/v1/super-admin/tickets/' . $ticket->id, [
            'amount_paid' => 5000,
        ]);

        $response->assertStatus(200)
            ->assertJsonCount(12, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'amount_paid'],
            ])
            ->assertJsonPath('data.amount_paid', '5,000.00');

        $this->assertDatabaseHas('tickets', [
            'amount_paid' => 5000,
        ]);
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_delete_ticket_belonging_to_all_user_roles()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $ticket = Ticket::factory()->create(['user_id' => $genericUser->id]);
        $ticket2 = Ticket::factory()->create(['user_id' => $genericUser->id]);
        $ticket3 = Ticket::factory()->create(['user_id' => $admin->id]);

        $response = $this->actingAs($superAdmin)->deleteJson('/api/v1/super-admin/tickets/' . $ticket->id);
        $response2 = $this->actingAs($admin)->deleteJson('/api/v1/super-admin/tickets/' . $ticket2->id);
        $response3 = $this->actingAs($genericUser)->deleteJson('/api/v1/super-admin/tickets/' . $ticket3->id);

        $response->assertNoContent();

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'deleted_at' => $ticket->updated_at,       // consider ignoring this line as the 'deleted_at' may differ from the 'updated_at' field by 1 second, thereby causing the test to fail; but will pass if ran again immediately after a failure.
        ])->assertDatabaseCount('tickets', 13);

        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_and_user_can_delete_ticket()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $ticket = Ticket::factory()->create(['user_id' => $genericUser->id]);
        $ticket2 = Ticket::factory()->create(['user_id' => $genericUser->id]);
        $ticket3 = Ticket::factory()->create(['user_id' => $genericUser->id]);

        $response = $this->actingAs($superAdmin)->deleteJson('/api/v1/super-admin/tickets/' . $ticket->id);
        $response2 = $this->actingAs($admin)->deleteJson('/api/v1/super-admin/tickets/' . $ticket2->id);
        $response3 = $this->actingAs($genericUser)->deleteJson('/api/v1/user/tickets/' . $ticket3->id);

        $response->assertNoContent();

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'deleted_at' => $ticket->updated_at,       // consider ignoring this line as the 'deleted_at' may differ from the 'updated_at' field by 1 second, thereby causing the test to fail; but will pass if ran again immediately after a failure.
        ])->assertDatabaseCount('tickets', 13);

        $response2->assertStatus(403);
        $response3->assertNoContent();
    }
}
