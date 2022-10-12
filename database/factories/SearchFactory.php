<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Search>
 */
class SearchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id'=>$this->faker->numberBetween(1,10),
            'keyword'=>$this->faker->randomElement(['Laravel','PHP','Html','Css','Google','Tailwind']),
            'date'=>Carbon::now()->format('Y-m-d'),
            'result'=> $this->faker->sentence(),

        ];
    }
}
