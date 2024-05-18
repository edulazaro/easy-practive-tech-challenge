<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Journal;
use App\Models\Client;

class JournalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clients = Client::all();

        foreach ($clients as $client) {
            $numberOfBookings = rand(0, 30);

            Journal::factory()->count($numberOfBookings)->create([
                'client_id' => $client->id,
            ]);
        }
    }
}