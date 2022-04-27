<?php namespace App;

interface WeatherDataRepositoryInterface
{
    /**
     * @param int $locationId
     * @param array $dataPoint
     *
     * @return void
     */
    public function storeDataPoint(int $locationId, array $dataPoint): void;

    /**
     * @param string $cityName
     * @param \DateTime $timestamp
     *
     * @return array|null
     */
    public function getDataPoint(string $cityName, \DateTime $timestamp): array|null;
}
