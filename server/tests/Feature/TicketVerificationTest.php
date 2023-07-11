<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Role;
use App\Models\Ticket;
use App\Models\TicketVerification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_super_admin_and_admin_can_retrieve_all_ticket_verifications()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $response = $this->actingAs($superAdmin)->getJson('/api/v1/super-admin/ticket-verifications');
        $response2 = $this->actingAs($admin)->getJson('/api/v1/admin/ticket-verifications');
        $response3 = $this->actingAs($genericUser)->getJson('/api/v1/super-admin/ticket-verifications');

        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(10, 'data');
        $response2->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(10, 'data');
        $response3->assertStatus(403);
    }

    public function test_only_super_admin_and_admin_can_create_ticket_verification()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $response = $this->actingAs($superAdmin)->postJson('/api/v1/super-admin/ticket-verifications', [
            'ticket_id' => Ticket::all()->random()->id,
            // 'user_id' => User::all()->random()->id,
            'user_id' => $superAdmin->id,
            'payment_confirmed' => true,
        ]);
        $response2 = $this->actingAs($admin)->postJson('/api/v1/admin/ticket-verifications', [
            'ticket_id' => Ticket::all()->random()->id,
            // 'user_id' => User::all()->random()->id,
            'user_id' => $admin->id,
            'payment_confirmed' => true,
        ]);
        $response3 = $this->actingAs($genericUser)->postJson('/api/v1/super-admin/ticket-verifications', [
            'ticket_id' => Ticket::all()->random()->id,
            // 'user_id' => User::all()->random()->id,
            'user_id' => $genericUser->id,
            'payment_confirmed' => true,
        ]);

        $response->assertStatus(201)
            ->assertJsonCount(4, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'payment_confirmed'],
            ])
            ->assertJsonPath('data.payment_confirmed', true);

        $this->assertDatabaseHas('ticket_verifications', [
            'payment_confirmed' => true,
        ]);
        $response2->assertStatus(201)
            ->assertJsonCount(4, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'payment_confirmed'],
            ])
            ->assertJsonPath('data.payment_confirmed', true);

        $this->assertDatabaseHas('ticket_verifications', [
            'payment_confirmed' => true,
        ]);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_and_admin_can_view_ticket_verifications_created_by_both_user_roles()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $ticketVerification1 = TicketVerification::factory()->create(['user_id' => $admin->id]);
        $ticketVerification2 = TicketVerification::factory()->create(['user_id' => $superAdmin->id]);
        $ticketVerification3 = TicketVerification::factory()->create(['user_id' => $admin->id]);

        $response = $this->actingAs($superAdmin)->getJson('/api/v1/super-admin/ticket-verifications/' . $ticketVerification1->id);
        $response2 = $this->actingAs($admin)->getJson('/api/v1/admin/ticket-verifications/' . $ticketVerification2->id);
        $response3 = $this->actingAs($genericUser)->getJson('/api/v1/super-admin/ticket-verifications/' . $ticketVerification3->id);

        $response->assertStatus(200)
            ->assertJsonCount(4, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'payment_confirmed'],
            ]);
        $response2->assertStatus(200)
            ->assertJsonCount(4, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'payment_confirmed'],
            ]);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_update_ticket()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $ticketVerification = TicketVerification::factory()->create();

        $response = $this->actingAs($superAdmin)->putJson('/api/v1/super-admin/ticket-verifications/' . $ticketVerification->id, [
            'payment_confirmed' => false,
        ]);

        $response2 = $this->actingAs($admin)->putJson('/api/v1/super-admin/ticket-verifications/' . $ticketVerification->id, [
            'payment_confirmed' => false,
        ]);

        $response3 = $this->actingAs($genericUser)->putJson('/api/v1/super-admin/ticket-verifications/' . $ticketVerification->id, [
            'payment_confirmed' => false,
        ]);

        $response->assertStatus(200)
            ->assertJsonCount(4, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'payment_confirmed'],
            ])
            ->assertJsonPath('data.payment_confirmed', false);

        $this->assertDatabaseHas('ticket_verifications', [
            'payment_confirmed' => false,
        ]);
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_delete_ticket_belonging_to_all_user_roles()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $ticketVerification = TicketVerification::factory()->create(['user_id' => $genericUser->id]);
        $ticketVerification2 = TicketVerification::factory()->create(['user_id' => $genericUser->id]);
        $ticketVerification3 = TicketVerification::factory()->create(['user_id' => $admin->id]);

        $response = $this->actingAs($superAdmin)->deleteJson('/api/v1/super-admin/ticket-verifications/' . $ticketVerification->id);
        $response2 = $this->actingAs($admin)->deleteJson('/api/v1/super-admin/ticket-verifications/' . $ticketVerification2->id);
        $response3 = $this->actingAs($genericUser)->deleteJson('/api/v1/super-admin/ticket-verifications/' . $ticketVerification3->id);

        $response->assertNoContent();

        $this->assertDatabaseHas('ticket_verifications', [
            'id' => $ticketVerification->id,
            'deleted_at' => $ticketVerification->updated_at,       // consider ignoring this line as the 'deleted_at' may differ from the 'updated_at' field by 1 second, thereby causing the test to fail; but will pass if ran again immediately after a failure.
        ])->assertDatabaseCount('ticket_verifications', 13);

        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }
}
