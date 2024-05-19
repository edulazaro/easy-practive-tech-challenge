<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Journal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JournalsDataControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a user cannot delete the journals of other users
     */
    public function test_unauthorized_user_cannot_delete_journal()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();

        $journal = Journal::factory()->create([
            'client_id' => $client->id,
        ]);

        $response = $this->actingAs($user)
            ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
            ->deleteJson(route('data.journals.destroy', $journal));

        $response->assertStatus(403);
        $this->assertDatabaseHas('journals', ['id' => $journal->id]);
    }

    /**
     * Test that a user can delete the journals of his clients
     */
    public function test_authorized_user_can_delete_journal()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create([
            'user_id' => $user->id,
        ]);

        $journal = Journal::factory()->create([
            'client_id' => $client->id,
        ]);

        $response = $this->actingAs($user)
            ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
            ->deleteJson(route('data.journals.destroy', $journal));

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'The Journal was successfully deleted',
            ]);

        $this->assertDatabaseMissing('journals', ['id' => $journal->id]);
    }
}
