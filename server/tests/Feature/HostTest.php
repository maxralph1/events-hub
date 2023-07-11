<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Host;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HostTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_super_admin_and_admin_can_retrieve_hosts()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $response = $this->actingAs($superAdmin)->getJson('/api/v1/super-admin/hosts');
        $response2 = $this->actingAs($admin)->getJson('/api/v1/super-admin/hosts');
        $response3 = $this->actingAs($genericUser)->getJson('/api/v1/super-admin/hosts');

        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(10, 'data');
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_create_event_host()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $response = $this->actingAs($superAdmin)->postJson('/api/v1/super-admin/hosts', [
            'name' => 'Host 1',
            'description' => 'This is Event Host One',
        ]);
        $response2 = $this->actingAs($admin)->postJson('/api/v1/super-admin/hosts', [
            'name' => 'Event Host 2',
            'description' => 'This is the Event Host II',
        ]);
        $response3 = $this->actingAs($genericUser)->postJson('/api/v1/super-admin/hosts', [
            'name' => 'Event Host 3',
            'description' => 'Here is Event Host 3',
        ]);

        $response->assertStatus(201)
            ->assertJsonCount(6, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'name'],
            ])
            ->assertJsonPath('data.name', 'Host 1');

        $this->assertDatabaseHas('hosts', [
            'name' => 'Host 1',
        ]);
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_view_event_host()
    {
        $host_id = Host::value('id');

        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $response = $this->actingAs($superAdmin)->getJson('/api/v1/super-admin/hosts/' . $host_id);
        $response2 = $this->actingAs($admin)->getJson('/api/v1/super-admin/hosts/' . $host_id);
        $response3 = $this->actingAs($genericUser)->getJson('/api/v1/super-admin/hosts/' . $host_id);

        $response->assertStatus(200)
            ->assertJsonCount(6, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'name'],
            ]);
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_update_event_host()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $host = Host::factory()->create();

        $response = $this->actingAs($superAdmin)->putJson('/api/v1/super-admin/hosts/' . $host->id, [
            'name' => 'Host 1 Updated',
        ]);

        $response2 = $this->actingAs($admin)->putJson('/api/v1/super-admin/hosts/' . $host->id, [
            'name' => 'Host II Updated',
        ]);

        $response3 = $this->actingAs($genericUser)->putJson('/api/v1/super-admin/hosts/' . $host->id, [
            'name' => 'Host 3 Updated',
        ]);

        $response->assertStatus(200)
            ->assertJsonCount(6, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'name'],
            ])
            ->assertJsonPath('data.name', 'Host 1 Updated');

        $this->assertDatabaseHas('hosts', [
            'name' => 'Host 1 Updated',
        ]);
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_delete_host()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $host = Host::factory()->create();
        $host2 = Host::factory()->create();
        $host3 = Host::factory()->create();

        $response = $this->actingAs($superAdmin)->deleteJson('/api/v1/super-admin/hosts/' . $host->id);
        $response2 = $this->actingAs($admin)->deleteJson('/api/v1/super-admin/hosts/' . $host2->id);
        $response3 = $this->actingAs($genericUser)->deleteJson('/api/v1/super-admin/hosts/' . $host3->id);

        $response->assertNoContent();

        $this->assertDatabaseHas('hosts', [
            'id' => $host->id,
            'deleted_at' => $host->updated_at,       // consider ignoring this line as the 'deleted_at' may differ from the 'updated_at' field by 1 second, thereby causing the test to fail; but will pass if ran again immediately after a failure.
        ])->assertDatabaseCount('hosts', 13);

        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }
}
