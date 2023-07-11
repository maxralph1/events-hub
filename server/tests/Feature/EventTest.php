<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Event;
use App\Models\EventHall;
use App\Models\Host;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_roles_via_their_respective_routes_can_retrieve_all_events()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $response = $this->actingAs($superAdmin)->getJson('/api/v1/super-admin/events');
        $response2 = $this->actingAs($admin)->getJson('/api/v1/admin/events');
        $response3 = $this->actingAs($genericUser)->getJson('/api/v1/user/events');

        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(10, 'data');
        $response2->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(10, 'data');
        $response3->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(10, 'data');
    }

    public function test_only_super_admin_can_create_events()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $description = fake()->text(100);

        $response = $this->actingAs($superAdmin)->postJson('/api/v1/super-admin/events', [
            'event_hall_id' => EventHall::all()->random()->id,
            'host_id' => Host::all()->random()->id,
            'user_id' => $superAdmin->id,
            'title' => fake()->text(20),
            // 'slug' => fake()->slug(),
            'description' => $description,
            'start_date' => fake()->date(now()->addDays(rand(1, 10))->toDateString()),
            'start_time' => fake()->time(),
            'end_date' => fake()->date(now()->addDays(rand(20, 40))->toDateString()),
            'end_time' => fake()->time(),
            'age_limit' => rand(13, 18),
        ]);
        $response2 = $this->actingAs($admin)->postJson('/api/v1/super-admin/events', [
            'event_hall_id' => EventHall::all()->random()->id,
            'host_id' => Host::all()->random()->id,
            'user_id' => $admin->id,
            'title' => fake()->text(20),
            // 'slug' => fake()->slug(),
            'description' => fake()->text(100),
            'start_date' => fake()->date(now()->addDays(rand(1, 10))->toDateString()),
            'start_time' => fake()->time(),
            'end_date' => fake()->date(now()->addDays(rand(20, 40))->toDateString()),
            'end_time' => fake()->time(),
            'age_limit' => rand(13, 18),
        ]);
        $response3 = $this->actingAs($genericUser)->postJson('/api/v1/super-admin/events', [
            'event_hall_id' => EventHall::all()->random()->id,
            'host_id' => Host::all()->random()->id,
            'user_id' => $genericUser->id,
            'title' => fake()->text(20),
            // 'slug' => fake()->slug(),
            'description' => fake()->text(100),
            'start_date' => fake()->date(now()->addDays(rand(1, 10))->toDateString()),
            'start_time' => fake()->time(),
            'end_date' => fake()->date(now()->addDays(rand(20, 40))->toDateString()),
            'end_time' => fake()->time(),
            'age_limit' => rand(13, 18),
        ]);

        $response->assertStatus(201)
            ->assertJsonCount(14, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'description'],
            ])
            ->assertJsonPath('data.description', $description);

        $this->assertDatabaseHas('events', [
            'description' => $description,
        ]);

        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_all_user_roles_via_their_respective_routes_can_view_event()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $viewableEvent = Event::all()->random();

        $response1 = $this->actingAs($superAdmin)->getJson('/api/v1/super-admin/events/' . $viewableEvent->id);
        $response2 = $this->actingAs($admin)->getJson('/api/v1/admin/events/' . $viewableEvent->id);
        $response3 = $this->actingAs($genericUser)->getJson('/api/v1/user/events/' . $viewableEvent->id);

        $response1->assertStatus(200)
            ->assertJsonCount(14, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'description'],
            ]);

        $response2->assertStatus(200)
            ->assertJsonCount(14, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'description'],
            ]);

        $response3->assertStatus(200)
            ->assertJsonCount(14, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'description'],
            ]);
    }

    public function test_only_superadmin_can_update_events()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $updatableEvent = Event::all()->random();

        $title = 'This is the updated event title.';

        $response = $this->actingAs($superAdmin)->putJson('/api/v1/super-admin/events/' . $updatableEvent->id, [
            'title' => $title,
        ]);

        $response2 = $this->actingAs($admin)->putJson('/api/v1/super-admin/events/' . $updatableEvent->id, [
            'title' => $title,
        ]);

        $response3 = $this->actingAs($genericUser)->putJson('/api/v1/super-admin/events/' . $updatableEvent->id, [
            'title' => $title,
        ]);

        $response->assertStatus(200)
            ->assertJsonCount(14, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'title'],
            ])
            ->assertJsonPath('data.title', $title);

        $this->assertDatabaseHas('events', [
            'title' => $title,
        ]);

        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_delete_events()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $event = Event::factory()->create();
        $event2 = Event::factory()->create();
        $event3 = Event::factory()->create();

        $response = $this->actingAs($superAdmin)->deleteJson('/api/v1/super-admin/events/' . $event->id);
        $response2 = $this->actingAs($admin)->deleteJson('/api/v1/super-admin/events/' . $event2->id);
        $response3 = $this->actingAs($genericUser)->deleteJson('/api/v1/super-admin/events/' . $event3->id);

        $response->assertNoContent();
        $response2->assertStatus(403);
        $response3->assertStatus(403);

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'deleted_at' => $event->updated_at,       // consider ignoring this line as the 'deleted_at' may differ from the 'updated_at' field by 1 second, thereby causing the test to fail; but will pass if ran again immediately after a failure.
        ])->assertDatabaseCount('events', 13);
    }
}
