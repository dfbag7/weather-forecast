<?php

namespace Tests\Feature;

use App\Models\Forecast;
use App\Models\Location;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetWeatherTest extends TestCase
{
    use DatabaseMigrations;
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function test_GetWeather_works()
    {
        $cityName = 'London';

        // setup the db

        /** @var Location $location */
        $location = Location::where('name', $cityName)->firstOrFail();

        /** @var Forecast $forecast */
        $forecast = Forecast::factory()
            ->for($location)
            ->create();

        // test

        $parameters = [
            'city' => $cityName,
            'timestamp' => $forecast->forecast_timestamp->format(DATE_ATOM)
        ];

        $response = $this
            ->withHeader('Accept', 'application/json')
            ->call('GET', '/api/weather', $parameters);

        // check the results

        $response->assertStatus(200);
    }

    public function test_GetWeatherWithWrongCite_fails()
    {
        $parameters = [
            'city' => 'Mexico', // not a valid city name
            'timestamp' => $this->faker->dateTimeThisDecade->format(DATE_ATOM),
        ];

        $response = $this
            ->withHeader('Accept', 'application/json')
            ->call('GET', '/api/weather', $parameters);

        $response->assertStatus(302);
    }

    public function test_GetWeatherWithWrongDate_fails()
    {
        $parameters = [
            'city' => 'London',
            'timestamp' => '2021-01-01x11:11:11Z', // not a valid ISO8601 timestamp
        ];

        $response = $this
            ->withHeader('Accept', 'application/json')
            ->call('GET', '/api/weather', $parameters);

        $response->assertStatus(302);
    }

    public function test_GetWeatherWithNonExistentDate_fails()
    {
        $parameters = [
            'city' => 'London',
            'timestamp' => '2000-01-01T00:00:00+00:00', // this date does not exist in the database
        ];

        $response = $this
            ->withHeader('Accept', 'application/json')
            ->call('GET', '/api/weather', $parameters);

        $response->assertStatus(404);
    }
}
