<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;

class ClientsDataControllerTest extends TestCase
{ 
    use RefreshDatabase;

    /**
     * It should not be possible to create a client without the required fields
     *
     * @return void
     */
    public function test_store_method_fails_without_required_fields()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('data.clients.store'), []);
    
        $response->assertStatus(422)->assertJsonValidationErrors(['name', 'email']);
    }

    /**
     * It should not be possible to create a client with an invalid email
     *
     * @return void
     */
    public function test_store_method_fails_with_an_invalid_email()
    {
        $user = User::factory()->create();
    
        $response = $this->actingAs($user)->postJson(route('data.clients.store'), [
            'name' => 'Edu',
            'email' => 'test@test'
        ]);
    
        $response->assertStatus(422)->assertJsonValidationErrors(['email']);
    }

    /**
     * It should not be possible to create a client with an invalid email
     *
     * @return void
     */
    public function test_store_method_fails_with_an_invalid_phone()
    {
        $user = User::factory()->create();
    
        $response = $this->actingAs($user)->postJson(route('data.clients.store'), [
            'name' => 'Edu',
            'phone' => '4653asdsad'
        ]);
    
        $response->assertStatus(422)->assertJsonValidationErrors(['phone']);
    }

    /**
     * It should not be possible to create a client with valid data
     *
     * @return void
     */
    public function test_store_method_creates_client_successfully()
    {
        $user = User::factory()->create();
        $clientData = [
            'name' => 'Edu',
            'email' => 'test@test.com',
            'phone' => '+34 324343243',
            'address' => 'Whatever streent',
            'city' => 'Anywhere',
            'postcode' => '32004'
        ];

        $response = $this->actingAs($user)->postJson(route('data.clients.store'), $clientData);

        $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'The client was successfully created.',
            'data' => [
                'name' => $clientData['name'],
                'email' => $clientData['email'],
                'phone' => $clientData['phone'],
                'address' => $clientData['address'],
                'city' => $clientData['city'],
                'postcode' => $clientData['postcode'],
            ]
        ]);

        $this->assertDatabaseHas('clients', [
            'name' => $clientData['name'],
            'email' => $clientData['email'],
            'phone' => $clientData['phone'],
            'address' => $clientData['address'],
            'city' => $clientData['city'],
            'postcode' => $clientData['postcode'],
            'user_id' => $user->id
        ]);
    }

    /**
     * It should be possible to create a client with only an email
     *
     * @return void
     */
    public function test_store_method_creates_client_successfully_with_only_email()
    {
        $user = User::factory()->create();
        $clientData = [
            'name' => 'Edu',
            'email' => 'test@test.com',
        ];

        $response = $this->actingAs($user)->postJson(route('data.clients.store'), $clientData);

        $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'The client was successfully created.',
            'data' => [
                'name' => $clientData['name'],
                'email' => $clientData['email'],
            ]
        ]);

        $this->assertDatabaseHas('clients', [
            'name' => $clientData['name'],
            'email' => $clientData['email'],
            'user_id' => $user->id
        ]);
    }

    /**
     * It should be possible to create a client with only a phone
     *
     * @return void
     */
    public function test_store_method_creates_client_successfully_with_only_phone()
    {
        $user = User::factory()->create();
        $clientData = [
            'name' => 'Edu',
            'phone' => '+34 324343243',
        ];

        $response = $this->actingAs($user)->postJson(route('data.clients.store'), $clientData);

        $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'The client was successfully created.',
            'data' => [
                'name' => $clientData['name'],
                'phone' => $clientData['phone'],
            ]
        ]);

        $this->assertDatabaseHas('clients', [
            'name' => $clientData['name'],
            'phone' => $clientData['phone'],
            'user_id' => $user->id
        ]);
    }
}
