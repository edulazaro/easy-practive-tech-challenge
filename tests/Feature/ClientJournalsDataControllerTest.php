<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Journal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientJournalsDataControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a user cannot get the journals of a client of another user
     */
    public function test_unauthorized_user_cannot_get_client_journals()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();

        Journal::factory()->count(4)->create([
            'client_id' => $client->id,
        ]);

        $response = $this->actingAs($user)
            ->getJson(route('data.clients.journals.index', [
                'client' => $client->id,
            ]));

        $response->assertStatus(403);
    }

    /**
     * Test that a user can get the journals of of of his clients
     */
    public function test_authorized_user_can_get_client_journals()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create([
            'user_id' => $user->id,
        ]);

        $journals = Journal::factory()->count(4)->create([
            'client_id' => $client->id,
        ]);

        $response = $this->actingAs($user)
            ->getJson(route('data.clients.journals.index', [
                'client' => $client->id,
            ]));

        $response->assertStatus(200);
        $response->assertJsonCount($journals->count());
    }

    /**
     * Test that a journal cannot be added without the required fields
     */
    public function test_cannot_add_journal_without_required_fields()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->postJson(route('data.clients.journals.store', $client), []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['date', 'content']);
    }

    /**
     * Test that a journal can be added with the required fields
     */
    public function test_journal_added_with_required_fields()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create([
            'user_id' => $user->id,
        ]);

        $journalData = [
            'date' => now()->toDateString(),
            'content' => 'Journal entry content',
        ];

        $response = $this->actingAs($user)
            ->postJson(
                route('data.clients.journals.store', $client),
                $journalData
            );

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'The journal was successfully created.',
                'data' => [
                    'date' => $journalData['date'],
                    'content' => $journalData['content'],
                ],
            ]);

        $this->assertDatabaseHas('journals', [
            'client_id' => $client->id,
            'date' => $journalData['date'],
            'content' => $journalData['content'],
        ]);
    }
}
