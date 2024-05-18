<?php

namespace Database\Factories;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Client;
use App\Models\Journal;

class JournalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Journal::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = Carbon::make(fake()->dateTimeBetween('-1 year', '+1 year'));

        return [
            'date' => $date,
            'content' => fake()->text(rand(100, 400), false)
        ];
    }

    public function withClient(): Factory
    {
        $client = Client::inRandomOrder()->first() ?? Client::factory()->create();

        return $this->state([
            'client_id' => $client,
        ]);
    }
}
