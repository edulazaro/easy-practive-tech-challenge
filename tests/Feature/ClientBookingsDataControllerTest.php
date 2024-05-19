<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use App\Models\Client;
use App\Models\Booking;

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
            'client_id' => $client->id
        ]);

        $response = $this->actingAs($user)->getJson(route('data.clients.bookings.index', [
            'client' => $client->id
        ]));

        $response->assertStatus(403);
    }

    /**
     * Test that a user can get the bookings of of of his clients
     */
    public function test_authorized_user_can_get_client_bookings()
    {
        $user = User::factory()->create();
        $client = Client::factory()->create([
            'user_id' => $user->id,
        ]);

        $bookings = Booking::factory()->count(4)->create([
            'client_id' => $client->id
        ]);

        $response = $this->actingAs($user)->getJson(route('data.clients.bookings.index', [
            'client' => $client->id
        ]));

        $response->assertStatus(200);
        $response->assertJsonCount($bookings->count());
    }

    /**
     * Test that a user can get the past bookings of of of his clients
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

        $response = $this->actingAs($user)->getJson(route('data.clients.bookings.index', [
            'client' => $client->id,
            'when' => 'past'
        ]));

        $response->assertStatus(200);
        $response->assertJsonCount($pastBookings->count());
        $response->assertJsonFragment(['start' => $dateBeforeNow->toDateTimeString()]);
    }


    /**
     * Test that a user can get the past bookings of of of his clients
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

        $response = $this->actingAs($user)->getJson(route('data.clients.bookings.index', [
            'client' => $client->id,
            'when' => 'future'
        ]));

        $response->assertStatus(200);
        $response->assertJsonCount($futureBookings->count());
        $response->assertJsonFragment(['start' => $dateAfterNow->toDateTimeString()]);
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
            'start' => $dateTomorrow ,
        ]);

        $datePastTomorrow = now()->addDays(2);
        Booking::factory()->create([
            'client_id' => $client->id,
            'start' => $datePastTomorrow,
        ]);

        $response = $this->actingAs($user)->getJson(route('data.clients.bookings.index', ['client' => $client->id]));

        $bookings = $response->json();

        $this->assertEquals($dateTomorrow ->toDateTimeString(), $bookings[0]['start']);
        $this->assertEquals($datePastTomorrow->toDateTimeString(), $bookings[1]['start']);
    }
}