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
use Illuminate\Log\LogManager;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateWeatherData
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private LogManager $logger;
    private WeatherDataSourceInterface $dataSource;
    private WeatherDataRepositoryInterface $dataRepository;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Logmanager $logger, WeatherDataSourceInterface $dataSource, WeatherDataRepositoryInterface $dataRepository)
    {
        $this->logger = $logger;
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
        $this->logger->info('Start updating weather data');

        try
        {
            $this->doUpdateWeatherData();

            WeatherUpdated::dispatch();
        }
        catch(\Exception $ex)
        {
            $this->logger->error('Error while updating weather data: ' . $ex);
        }

        $this->logger->info('Finish updating weather data');
    }

    /**
     * @return void
     */
    public function doUpdateWeatherData(): void
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
    }
}
