<?php

namespace App\Providers;

use App\WeatherDataRepository;
use App\WeatherDataRepositoryInterface;
use App\WeatherDataSource;
use App\WeatherDataSourceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(WeatherDataRepositoryInterface::class, WeatherDataRepository::class);
        $this->app->bind(WeatherDataSourceInterface::class, WeatherDataSource::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
