<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Client;

class ClientFactory extends Factory
{
    /** @var string The name of the factory's corresponding model. */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name,
            'email' => fake()->email,
            'phone' => fake()->phoneNumber,
            'address' => fake()->streetAddress,
            'city' => fake()->city,
            'postcode' => fake()->postcode,
        ];
    }

    public function withNewUser(): Factory
    {
        $user = User::factory()->create();
        return $this->state([
            'user_id' => $user,
        ]);
 
    }

    public function withUser(): Factory
    {
        $user = User::inRandomOrder()->first() ?? User::factory()->create();
        return $this->state([
            'user_id' => $user,
        ]);
 
    }
}
