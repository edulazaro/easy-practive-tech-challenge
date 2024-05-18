<?php

namespace Database\Factories;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Booking;
use App\Models\Client;

class BookingFactory extends Factory
{
    /** @var string The name of the factory's corresponding model. */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = Carbon::make(fake()->dateTimeBetween('-1 year', '+1 year'));
        $end = $start->copy()->addMinutes(fake()->randomElement([15, 30, 45, 60, 75, 90]));
    
        return [
            'start' => $start,
            'end' => $end,
            'notes' => fake()->boolean(30) ? fake()->paragraphs(1, true) : '',
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
