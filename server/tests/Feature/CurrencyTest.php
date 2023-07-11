<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Currency;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurrencyTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_super_admin_and_admin_can_retrieve_currencies()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $response = $this->actingAs($superAdmin)->getJson('/api/v1/super-admin/currencies');
        $response2 = $this->actingAs($admin)->getJson('/api/v1/super-admin/currencies');
        $response3 = $this->actingAs($genericUser)->getJson('/api/v1/super-admin/currencies');

        $response->assertStatus(200)
            ->assertJsonStructure(['data'])
            ->assertJsonCount(10, 'data');
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_create_currency()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $response = $this->actingAs($superAdmin)->postJson('/api/v1/super-admin/currencies', [
            'title' => 'SEK',
            'description' => 'Swedish Krona',
        ]);
        $response2 = $this->actingAs($admin)->postJson('/api/v1/super-admin/currencies', [
            'title' => 'EUR',
            'description' => 'Eurozone Currency',
        ]);
        $response3 = $this->actingAs($genericUser)->postJson('/api/v1/super-admin/currencies', [
            'title' => 'CHF',
            'description' => 'Swiss Franc',
        ]);

        $response->assertStatus(201)
            ->assertJsonCount(6, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'title'],
            ])
            ->assertJsonPath('data.title', 'SEK');

        $this->assertDatabaseHas('currencies', [
            'title' => 'SEK',
        ]);
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_view_currency()
    {
        $currency_id = Currency::value('id');

        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $response = $this->actingAs($superAdmin)->getJson('/api/v1/super-admin/currencies/' . $currency_id);
        $response2 = $this->actingAs($admin)->getJson('/api/v1/super-admin/currencies/' . $currency_id);
        $response3 = $this->actingAs($genericUser)->getJson('/api/v1/super-admin/currencies/' . $currency_id);

        $response->assertStatus(200)
            ->assertJsonCount(6, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'title'],
            ]);
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_update_country()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $currency = Currency::factory()->create();

        $response = $this->actingAs($superAdmin)->putJson('/api/v1/super-admin/currencies/' . $currency->id, [
            'title' => 'USD2',
        ]);

        $response2 = $this->actingAs($admin)->putJson('/api/v1/super-admin/currencies/' . $currency->id, [
            'title' => 'USD2',
        ]);

        $response3 = $this->actingAs($genericUser)->putJson('/api/v1/super-admin/currencies/' . $currency->id, [
            'title' => 'USD2',
        ]);

        $response->assertStatus(200)
            ->assertJsonCount(6, 'data')
            ->assertJsonStructure([
                'data' => ['0' => 'title'],
            ])
            ->assertJsonPath('data.title', 'USD2');

        $this->assertDatabaseHas('currencies', [
            'title' => 'USD2',
        ]);
        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }

    public function test_only_superadmin_can_delete_country()
    {
        $superAdmin = User::factory()->create(['role_id' => Role::where('title', 'super-admin')->first()]);
        $admin = User::factory()->create(['role_id' => Role::where('title', 'admin')->first()]);
        $genericUser = User::factory()->create(['role_id' => Role::where('title', 'generic-user')->first()]);

        $currency = Currency::factory()->create();
        $currency2 = Currency::factory()->create();
        $currency3 = Currency::factory()->create();

        $response = $this->actingAs($superAdmin)->deleteJson('/api/v1/super-admin/currencies/' . $currency->id);
        $response2 = $this->actingAs($admin)->deleteJson('/api/v1/super-admin/currencies/' . $currency2->id);
        $response3 = $this->actingAs($genericUser)->deleteJson('/api/v1/super-admin/currencies/' . $currency3->id);

        $response->assertNoContent();

        $this->assertDatabaseHas('currencies', [
            'id' => $currency->id,
            'deleted_at' => $currency->updated_at,       // consider ignoring this line as the 'deleted_at' may differ from the 'updated_at' field by 1 second, thereby causing the test to fail; but will pass if ran again immediately after a failure.
        ])->assertDatabaseCount('currencies', 13);

        $response2->assertStatus(403);
        $response3->assertStatus(403);
    }
}
