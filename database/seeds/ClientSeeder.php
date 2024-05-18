<?php

use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first() ?? factory(User::class)->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        factory(Client::class, 150)->create([
            'user_id' => $user->id,
        ]);
    }
}
