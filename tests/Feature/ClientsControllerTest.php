<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The index view should not include clients beloging to other users
     *
     * @return void
     */
    public function test_index_should_not_return_clients_of_other_users()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();

        $response = $this->actingAs($user)->get(route('clients.index'));

        $response->assertStatus(200);
        $response->assertViewIs('clients.index');
        $response->assertViewHas('clients', function ($clients) use ($client) {
            return ! $clients->contains($client);
        });
    }

    /**
     * It should be possible to see the clients in the index view
     *
     * @return void
     */
    public function test_index_method_returns_correct_view_with_data()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('clients.index'));

        $response->assertStatus(200);
        $response->assertViewIs('clients.index');
        $response->assertViewHas('clients', function ($clients) use ($client) {
            return $clients->contains($client);
        });
    }

    /**
     * It should be possible to view the create client form
     *
     * @return void
     */
    public function test_create_method_returns_correct_view()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('clients.create'));

        $response->assertStatus(200);
        $response->assertViewIs('clients.create');
    }

    /**
     * It should not be possible to view a user from another user
     *
     * @return void
     */
    public function test_show_method_aborts_for_unauthorized_user()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('clients.show', $client));

        $response->assertStatus(403);
    }

    /**
     * It should not be possible to view a user assigned to the authorized user
     *
     * @return void
     */
    public function test_show_method_returns_correct_view_for_authorized_user()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->get(route('clients.show', $client));

        $response->assertStatus(200);
        $response->assertViewIs('clients.show');
        $response->assertViewHas('client', $client);
    }
}
