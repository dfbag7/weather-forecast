<?php

namespace Database\Factories;

use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Forecast>
 */
class ForecastFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'location_id' => Location::factory(),
            'forecast_timestamp' => $this->faker->dateTimeThisDecade(),
            'temp_min' => $this->faker->randomFloat(2, -50.0, 50.0),
            'temp_max' => $this->faker->randomFloat(2, -50.0, 50.0),
            'pressure' => $this->faker->numberBetween(800, 1100),
            'humidity' => $this->faker->numberBetween(0, 100),
        ];
    }
}
