<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Client;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientBookingsDataControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a user cannot get the bookings of a client of another user
     */
    public function test_unauthorized_user_cannot_get_client_bookings()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();

        Booking::factory()->count(4)->create([
            'client_id' => $client->id,
        ]);

        $response = $this->actingAs($user)
            ->getJson(route('data.clients.bookings.index', [
                'client' => $client->id,
            ]));

        $response->assertStatus(403);
    }

    /**
     * Test that a user can get the bookings of his clients
     */
    public function test_authorized_user_can_get_client_bookings()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create([
            'user_id' => $user->id,
        ]);

        $bookings = Booking::factory()->count(4)->create([
            'client_id' => $client->id,
        ]);

        $response = $this->actingAs($user)
            ->getJson(route('data.clients.bookings.index', [
                'client' => $client->id,
            ]));

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'success' => true,
            'collection' => $bookings->toArray()
        ]);
    }

    /**
     * Test that a user can get the past bookings of his clients
     */
    public function test_authorized_user_can_get_past_client_bookings()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create([
            'user_id' => $user->id,
        ]);

        $dateBeforeNow = now()->subDays(10);
        $pastBookings = Booking::factory()->count(3)->create([
            'client_id' => $client->id,
            'start' => $dateBeforeNow,
        ]);

        $dateAfterNow = now()->addDays(10);
        Booking::factory()->count(2)->create([
            'client_id' => $client->id,
            'start' => $dateAfterNow,
        ]);

        $response = $this->actingAs($user)
            ->getJson(route('data.clients.bookings.index', [
                'client' => $client->id,
                'when' => 'past',
            ]));

        $response->assertStatus(200);

        $response->assertJson([
            'success' => true,
        ]);

        $response->assertJsonCount(3, 'collection');

        foreach ($pastBookings as $booking) {
            $response->assertJsonFragment([
                'id' => $booking->id,
                'start' => $booking->start->format('Y-m-d H:i:s'),
                'client_id' => $client->id
            ]);
        }
    }

    /**
     * Test that a user can get the FUTURE bookings of his clients
     */
    public function test_authorized_user_can_get_future_client_bookings()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create([
            'user_id' => $user->id,
        ]);

        $dateBeforeNow = now()->subDays(10);
        Booking::factory()->count(3)->create([
            'client_id' => $client->id,
            'start' => $dateBeforeNow,
        ]);

        $dateAfterNow = now()->addDays(10);
        $futureBookings = Booking::factory()->count(2)->create([
            'client_id' => $client->id,
            'start' => $dateAfterNow,
        ]);

        $response = $this->actingAs($user)
            ->getJson(route('data.clients.bookings.index', [
                'client' => $client->id,
                'when' => 'future',
            ]));

        $response->assertStatus(200);

        $response->assertJson([
            'success' => true,
        ]);

        $response->assertJsonCount(2, 'collection');

        $response->assertJsonFragment([
            'success' => true,
            'collection' => $futureBookings->toArray()
        ]);

        foreach ($futureBookings as $booking) {
            $response->assertJsonFragment([
                'id' => $booking->id,
                'start' => $booking->start->format('Y-m-d H:i:s'),
                'client_id' => $client->id
            ]);
        }
    }

    /**
     * Test that the bookings are ordered by start date
     */
    public function test_bookings_ordered_by_start_date()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create([
            'user_id' => $user->id,
        ]);

        $dateTomorrow = now()->addDays(1);
        Booking::factory()->create([
            'client_id' => $client->id,
            'start' => $dateTomorrow,
        ]);

        $datePastTomorrow = now()->addDays(2);
        Booking::factory()->create([
            'client_id' => $client->id,
            'start' => $datePastTomorrow,
        ]);

        $response = $this->actingAs($user)
            ->getJson(route('data.clients.bookings.index', [
                'client' => $client->id,
            ]));

        $bookings = $response->json(['collection']);

        $this->assertEquals(
            $dateTomorrow->toDateTimeString(),
            $bookings[0]['start']
        );

        $this->assertEquals(
            $datePastTomorrow->toDateTimeString(),
            $bookings[1]['start']
        );
    }
}
