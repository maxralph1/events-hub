<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\WithFaker;
use App\Models\EventHall;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventHallTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_super_admin_can_retrieve_event_halls()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $response = $this->actingAs($superAdmin)->getJson('/api/v1/super-admin/event-halls');
        $response2 = $this->actingAs($admin)->getJson('/api/v1/super-admin/event-halls');
        $response3 = $this->actingAs($genericUser)->getJson('/api/v1/super-admin/event-halls');

        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(10, 'data');
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_create_event_hall()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $response = $this->actingAs($superAdmin)->postJson('/api/v1/super-admin/event-halls', [
            'name' => 'Hall 1',
            'description' => 'This is Event Hall One',
        ]);
        $response2 = $this->actingAs($admin)->postJson('/api/v1/super-admin/event-halls', [
            'name' => 'Event Hall 2',
            'description' => 'This is the Event Hall II',
        ]);
        $response3 = $this->actingAs($genericUser)->postJson('/api/v1/super-admin/event-halls', [
            'name' => 'Event Hall 3',
            'description' => 'Here is Event Hall 3',
        ]);

        $response->assertStatus(201)
            ->assertJsonCount(6, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'name'],
            ])
            ->assertJsonPath('data.name', 'Hall 1');

        $this->assertDatabaseHas('event_halls', [
            'name' => 'Hall 1',
        ]);
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_view_event_hall()
    {
        $eventHall_id = EventHall::value('id');

        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $response = $this->actingAs($superAdmin)->getJson('/api/v1/super-admin/event-halls/' . $eventHall_id);
        $response2 = $this->actingAs($admin)->getJson('/api/v1/super-admin/event-halls/' . $eventHall_id);
        $response3 = $this->actingAs($genericUser)->getJson('/api/v1/super-admin/event-halls/' . $eventHall_id);

        $response->assertStatus(200)
            ->assertJsonCount(6, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'name'],
            ]);
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_update_event_hall()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $eventHall = EventHall::factory()->create();

        $response = $this->actingAs($superAdmin)->putJson('/api/v1/super-admin/event-halls/' . $eventHall->id, [
            'name' => 'Hall 1 Updated',
        ]);

        $response2 = $this->actingAs($admin)->putJson('/api/v1/super-admin/event-halls/' . $eventHall->id, [
            'name' => 'Hall II Updated',
        ]);

        $response3 = $this->actingAs($genericUser)->putJson('/api/v1/super-admin/event-halls/' . $eventHall->id, [
            'name' => 'Hall 3 Updated',
        ]);

        $response->assertStatus(200)
            ->assertJsonCount(6, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'name'],
            ])
            ->assertJsonPath('data.name', 'Hall 1 Updated');

        $this->assertDatabaseHas('event_halls', [
            'name' => 'Hall 1 Updated',
        ]);
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_delete_category()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $eventHall = EventHall::factory()->create();
        $eventHall2 = EventHall::factory()->create();
        $eventHall3 = EventHall::factory()->create();

        $response = $this->actingAs($superAdmin)->deleteJson('/api/v1/super-admin/event-halls/' . $eventHall->id);
        $response2 = $this->actingAs($admin)->deleteJson('/api/v1/super-admin/event-halls/' . $eventHall2->id);
        $response3 = $this->actingAs($genericUser)->deleteJson('/api/v1/super-admin/event-halls/' . $eventHall3->id);

        $response->assertNoContent();

        $this->assertDatabaseHas('event_halls', [
            'id' => $eventHall->id,
            'deleted_at' => $eventHall->updated_at,       // consider ignoring this line as the 'deleted_at' may differ from the 'updated_at' field by 1 second, thereby causing the test to fail; but will pass if ran again immediately after a failure.
        ])->assertDatabaseCount('event_halls', 13);

        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }
}
