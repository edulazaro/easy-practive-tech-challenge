<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Booking;
use App\Models\Client;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $clients = Client::all();

        foreach ($clients as $client) {
            $numberOfBookings = rand(0, 30);

            Booking::factory()->count($numberOfBookings)->create([
                'client_id' => $client->id,
            ]);
        }
    }
}
