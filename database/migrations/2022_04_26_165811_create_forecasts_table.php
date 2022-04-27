<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forecasts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('location_id');
            $table->timestamp('forecast_timestamp');
            $table->float('temp_min');
            $table->float('temp_max');
            $table->float('pressure');
            $table->float('humidity');

            $table->foreign('location_id')->references('id')->on('locations');
            $table->unique(['location_id', 'forecast_timestamp']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forecasts');
    }
};
