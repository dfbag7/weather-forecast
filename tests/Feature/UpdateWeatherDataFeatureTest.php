<?php

namespace Tests\Feature;

use App\Jobs\UpdateWeatherData;
use App\Models\Forecast;
use App\Models\Location;
use App\WeatherDataSourceInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class UpdateWeatherDataFeatureTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_whole_UpdateWeatherData_Works()
    {
        /** @var Location $location */
        $location = Location::factory()->create();

        // Mock the data source interface, but not the data repository.
        // This allows to test the database-related code.

        $dataPoint = [
            'forecast_timestamp' => $this->faker->dateTimeThisDecade,
            'temp_min' => $this->faker->randomFloat(2, -50.0, 50.0),
            'temp_max' => $this->faker->randomFloat(2, -50.0, 50.0),
            'pressure' => $this->faker->numberBetween(800, 1100),
            'humidity' => $this->faker->numberBetween(0, 100),
        ];

        $this->instance(WeatherDataSourceInterface::class, Mockery::mock(WeatherDataSourceInterface::class, function(MockInterface $mock) use($dataPoint) {
                $mock->shouldReceive('getWeatherData')
                    ->once()
                    ->andReturn([$dataPoint]);
            })
        );

        $job = $this->app->make(UpdateWeatherData::class);
        $job->doUpdateWeatherData();

        $this->assertDatabaseHas(Forecast::class, [
            'location_id' => $location->id,
        ]);
    }
}
