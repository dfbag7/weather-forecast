<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currentTimestamp = Carbon::now();

        \DB::table('locations')->insert([
            'created_at' => $currentTimestamp,
            'updated_at' => $currentTimestamp,
            'name' => 'London',
            'lat' => 51.5073219,
            'lon' => -0.1276474,
        ]);

        \DB::table('locations')->insert([
            'created_at' => $currentTimestamp,
            'updated_at' => $currentTimestamp,
            'name' => 'New York',
            'lat' => 40.7127281,
            'lon' => -74.0060152,
        ]);

        \DB::table('locations')->insert([
            'created_at' => $currentTimestamp,
            'updated_at' => $currentTimestamp,
            'name' => 'Paris',
            'lat' => 48.8588897,
            'lon' => 2.3200410217200766,
        ]);

        \DB::table('locations')->insert([
            'created_at' => $currentTimestamp,
            'updated_at' => $currentTimestamp,
            'name' => 'Berlin',
            'lat' => 52.5170365,
            'lon' => 13.3888599,
        ]);

        \DB::table('locations')->insert([
            'created_at' => $currentTimestamp,
            'updated_at' => $currentTimestamp,
            'name' => 'Tokyo',
            'lat' => 35.6828387,
            'lon' => 139.7594549,
        ]);
    }
}
