<?php namespace App;

use App\Models\Forecast;
use Carbon\Carbon;

class WeatherDataRepository implements WeatherDataRepositoryInterface
{

    /**
     * @inheritDoc
     *
     * @param int $locationId
     * @param array $dataPoint
     *
     * @return void
     */
    public function storeDataPoint(int $locationId, array $dataPoint): void
    {
        $currentTime = Carbon::now('UTC');

        // trying to optimize the database operation
        \DB::statement("
                    insert into forecasts(created_at, updated_at, location_id, forecast_timestamp, temp_min, temp_max, pressure, humidity)
                    values (?, ?, ?, ?, ?, ?, ?, ?)
                    on duplicate key update
                        updated_at = ?,
                        temp_min = ?,
                        temp_max = ?,
                        pressure = ?,
                        humidity = ?",
            [
                $currentTime,
                $currentTime,
                $locationId,
                $dataPoint['forecast_timestamp'],
                $dataPoint['temp_min'],
                $dataPoint['temp_max'],
                $dataPoint['pressure'],
                $dataPoint['humidity'],

                $currentTime,
                $dataPoint['temp_min'],
                $dataPoint['temp_max'],
                $dataPoint['pressure'],
                $dataPoint['humidity'],
            ]);
    }

    /**
     * @inheritDoc
     * @param string $cityName
     * @param \DateTime $timestamp
     *
     * @return array|null
     */
    public function getDataPoint(string $cityName, \DateTime $timestamp): array|null
    {
        $forecast = Forecast::query()
            ->whereRelation('location', 'name', $cityName)
            ->where('forecast_timestamp', '>=', $timestamp)
            ->orderBy('forecast_timestamp')
            ->limit(1)
            ->first();

        if ($forecast === null)
            return null;

        return [
            'forecast_timestamp' => $forecast->forecast_timestamp,
            'temp_min' => $forecast->temp_min,
            'temp_max' => $forecast->temp_max,
            'pressure' => $forecast->pressure,
            'humidity' => $forecast->humidity,
        ];
    }
}
