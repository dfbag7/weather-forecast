<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\WeatherDataRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    private WeatherDataRepositoryInterface $dataRepository;

    public function __construct(WeatherDataRepositoryInterface $dataRepository)
    {
        $this->dataRepository = $dataRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        $validated = $request->validate([
            'city' => [ 'required', 'exists:locations,name' ],
            'timestamp' => [ 'required', 'date_format:' . DATE_ATOM, ]
        ]);

        $timestamp = Carbon::createFromFormat(DATE_ATOM, $validated['timestamp']);

        $dataPoint = $this->dataRepository->getDataPoint($validated['city'], $timestamp);

        if ($dataPoint === null)
            \App::abort(404, 'Not found');

        return response($dataPoint);
    }
}
