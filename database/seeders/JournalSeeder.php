<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Journal;
use Illuminate\Database\Seeder;

class JournalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
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
