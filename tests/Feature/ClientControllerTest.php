<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_clients_can_be_listed(): void
    {
        $user = User::factory()->create();
        Client::factory()->count(3)->create(['created_by' => $user->id]);

        $response = $this->actingAs($user)->get(route('clients.index'));

        $response->assertStatus(200);
        $response->assertViewHas('clients');
    }

    public function test_create_client_page_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('clients.create'));

        $response->assertStatus(200);
    }

    public function test_new_clients_can_be_created(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('clients.store'), [
            'name' => 'Test Client',
            'email' => 'test@client.com',
            'phone' => '1234567890',
            'country' => 'Test Country',
            'address' => '123 Test St',
            'enabled' => true,
        ]);

        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseHas('clients', [
            'name' => 'Test Client',
            'email' => 'test@client.com',
        ]);
    }

    public function test_client_edit_page_can_be_rendered(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['created_by' => $user->id]);

        $response = $this->actingAs($user)->get(route('clients.edit', $client));

        $response->assertStatus(200);
        $response->assertViewHas('client');
    }

    public function test_clients_can_be_updated(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['created_by' => $user->id]);

        $response = $this->actingAs($user)->patch(route('clients.update', $client), [
            'name' => 'Updated Client Name',
            'email' => 'updated@client.com',
        ]);

        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'name' => 'Updated Client Name',
            'email' => 'updated@client.com',
        ]);
    }

    public function test_clients_can_be_soft_deleted(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['created_by' => $user->id]);

        $response = $this->actingAs($user)->delete(route('clients.destroy', $client));

        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseHas('clients', [
            'id' => $client->id,
            'removed' => true,
        ]);
    }
}
