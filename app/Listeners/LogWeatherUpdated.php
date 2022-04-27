<?php

namespace App\Listeners;

use App\Events\WeatherUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogWeatherUpdated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\WeatherUpdated  $event
     * @return void
     */
    public function handle(WeatherUpdated $event)
    {
        \Log::info('Weather data has been updated');
    }
}
