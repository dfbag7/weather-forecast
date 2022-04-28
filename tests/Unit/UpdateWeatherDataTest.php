<?php namespace Tests\Unit;

use Mockery;
use Mockery\MockInterface;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Jobs\UpdateWeatherData;
use App\Models\Location;
use App\WeatherDataRepositoryInterface;
use App\WeatherDataSourceInterface;
use Tests\TestCase;

class UpdateWeatherDataTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_UpdateWeatherData_Works()
    {
        /** @var Location $location */
        $location = Location::factory()->create();

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

        $this->instance(WeatherDataRepositoryInterface::class, Mockery::mock(WeatherDataRepositoryInterface::class, function(MockInterface $mock) use($location, $dataPoint) {
            $mock->shouldReceive('storeDataPoint')
                ->with($location->id, $dataPoint);
            })
        );

        $job = $this->app->make(UpdateWeatherData::class);
        $job->doUpdateWeatherData();
    }
}
