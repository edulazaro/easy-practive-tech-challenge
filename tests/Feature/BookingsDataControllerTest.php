<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use App\Models\Client;
use App\Models\Booking;

class BookingsDataControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a user cannot delete the bokkings of other users
     */
    public function test_unauthorized_user_cannot_delete_booking()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();

        $booking = Booking::factory()->create([
            'client_id' => $client->id
        ]);

        $response = $this->actingAs($user)->deleteJson(route('data.bookings.destroy', $booking));

        $response->assertStatus(403);
        $this->assertDatabaseHas('bookings', ['id' => $booking->id]);
    }

    /**
     * Test that a user can delete one of his bookings
     */
    public function test_authorized_user_can_delete_booking()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create([
            'user_id' => $user->id,
        ]);

        $booking = Booking::factory()->create([
            'client_id' => $client->id
        ]);

        $response = $this->actingAs($user)->deleteJson(route('data.bookings.destroy', $booking));

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'The Booking was successfully deleted'
            ]);

        $this->assertDatabaseMissing('bookings', ['id' => $booking->id]);
    }
}
