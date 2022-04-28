<?php

namespace App\Jobs;

use App\Events\WeatherUpdated;
use App\Models\Location;
use App\WeatherDataRepositoryInterface;
use App\WeatherDataSourceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateWeatherData
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private WeatherDataSourceInterface $dataSource;
    private WeatherDataRepositoryInterface $dataRepository;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(WeatherDataSourceInterface $dataSource, WeatherDataRepositoryInterface $dataRepository)
    {
        $this->dataSource = $dataSource;
        $this->dataRepository = $dataRepository;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Log::info('Start updating weather data');

        try
        {
            /** @var Location[] $locations */
            $locations = Location::all();
            foreach($locations as $location)
            {
                $data = $this->dataSource->getWeatherData($location->lat, $location->lon);

                foreach($data as $dataPoint)
                {
                    $this->dataRepository->storeDataPoint($location->id, $dataPoint);
                }
            }

            WeatherUpdated::dispatch();
        }
        catch(\Exception $ex)
        {
            \Log::error('Error while updating weather data: ' . $ex);
        }

        \Log::info('Finish updating weather data');
    }
}
