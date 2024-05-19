<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Client;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

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
            'client_id' => $client->id,
        ]);

        $response = $this->actingAs($user)
            ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
            ->deleteJson(route('data.bookings.destroy', $booking));

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
            'client_id' => $client->id,
        ]);

        $response = $this->actingAs($user)
            ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
            ->deleteJson(
                route('data.bookings.destroy', $booking)
            );

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'The Booking was successfully deleted',
            ]);

        $this->assertDatabaseMissing('bookings', ['id' => $booking->id]);
    }

    /**
     * Test that a booking cannot be added without the required fields
     */
    public function test_cannot_add_booking_without_required_fields()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
            ->postJson(route('data.clients.bookings.store', $client), []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['start', 'end']);
    }

    /**
     * Test that a booking can be added with the required fields
     */
    public function test_booking_added_with_required_fields()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create([
            'user_id' => $user->id,
        ]);

        $startDate = Carbon::now();
        $endDate = Carbon::now()->addHours(1);

        $bookingData = [
            'start' => $startDate->format('Y-m-d\TH:i'),
            'end' => $endDate->format('Y-m-d\TH:i'),
            'notes' => 'Booking entry notes',
        ];

        $response = $this->actingAs($user)
            ->withHeaders(['X-Requested-With' => 'XMLHttpRequest'])
            ->postJson(
                route('data.clients.bookings.store', $client), $bookingData
            );

        $this->assertDatabaseHas('bookings', [
            'id' => $response->json()['data']['id'],
            'client_id' => $client->id,
        ]);
    }
}
