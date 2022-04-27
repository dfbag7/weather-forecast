<?php namespace App;

use Carbon\Carbon;
use RakibDevs\Weather\Weather;

class WeatherDataSource implements WeatherDataSourceInterface
{
    private Weather $weather;

    public function __construct(Weather $weather)
    {
        $this->weather = $weather;
    }

    public function getWeatherData(float $lat, float $lon): array
    {
        $data = $this->weather->get3HourlyByCord($lat, $lon);

        $result = [];
        foreach($data->list as $entry)
        {
            $result[] = [
                'forecast_timestamp' => Carbon::createFromFormat('Y-m-d H:i:s', $entry->dt),
                'temp_min' => $entry->main->temp_min,
                'temp_max' => $entry->main->temp_max,
                'pressure' => $entry->main->pressure,
                'humidity' => $entry->main->humidity,
            ];
        }

        return $result;
    }
}
