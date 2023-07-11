<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CountryTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_super_admin_and_admin_can_retrieve_countries()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $response = $this->actingAs($superAdmin)->getJson('/api/v1/super-admin/countries');
        $response2 = $this->actingAs($admin)->getJson('/api/v1/super-admin/countries');
        $response3 = $this->actingAs($genericUser)->getJson('/api/v1/super-admin/countries');

        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(10, 'data');
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_create_country()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $response = $this->actingAs($superAdmin)->postJson('/api/v1/super-admin/countries', [
            'name' => 'Sweden',
        ]);
        $response2 = $this->actingAs($admin)->postJson('/api/v1/super-admin/countries', [
            'name' => 'Germany',
        ]);
        $response3 = $this->actingAs($genericUser)->postJson('/api/v1/super-admin/countries', [
            'name' => 'Switzerland',
        ]);

        $response->assertStatus(201)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'name'],
            ])
            ->assertJsonPath('data.name', 'Sweden');

        $this->assertDatabaseHas('countries', [
            'name' => 'Sweden',
        ]);
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_view_country()
    {
        $country_id = Country::value('id');

        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $response = $this->actingAs($superAdmin)->getJson('/api/v1/super-admin/countries/' . $country_id);
        $response2 = $this->actingAs($admin)->getJson('/api/v1/super-admin/countries/' . $country_id);
        $response3 = $this->actingAs($genericUser)->getJson('/api/v1/super-admin/countries/' . $country_id);

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'name'],
            ]);
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_update_country()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $country = Country::factory()->create();

        $response = $this->actingAs($superAdmin)->putJson('/api/v1/super-admin/countries/' . $country->id, [
            'name' => 'Country Updated',
        ]);

        $response2 = $this->actingAs($admin)->putJson('/api/v1/super-admin/countries/' . $country->id, [
            'name' => 'Country Updated II',
        ]);

        $response3 = $this->actingAs($genericUser)->putJson('/api/v1/super-admin/countries/' . $country->id, [
            'name' => 'Country Updated III',
        ]);

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'name'],
            ])
            ->assertJsonPath('data.name', 'Country Updated');

        $this->assertDatabaseHas('countries', [
            'name' => 'Country Updated',
        ]);
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_delete_country()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $country = Country::factory()->create();
        $country2 = Country::factory()->create();
        $country3 = Country::factory()->create();

        $response = $this->actingAs($superAdmin)->deleteJson('/api/v1/super-admin/countries/' . $country->id);
        $response2 = $this->actingAs($admin)->deleteJson('/api/v1/super-admin/countries/' . $country2->id);
        $response3 = $this->actingAs($genericUser)->deleteJson('/api/v1/super-admin/countries/' . $country3->id);

        $response->assertNoContent();

        $this->assertDatabaseHas('countries', [
            'id' => $country->id,
            'deleted_at' => $country->updated_at,       // consider ignoring this line as the 'deleted_at' may differ from the 'updated_at' field by 1 second, thereby causing the test to fail; but will pass if ran again immediately after a failure.
        ])->assertDatabaseCount('countries', 13);

        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }
}
