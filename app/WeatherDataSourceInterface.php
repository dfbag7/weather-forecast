<?php namespace App;

interface WeatherDataSourceInterface
{
    /**
     * @param float $lat
     * @param float $lon
     *
     * @return array
     */
    public function getWeatherData(float $lat, float $lon): array;
}
