<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Forecast
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $location_id
 * @property string $forecast_timestamp
 * @property float $temp_min
 * @property float $temp_max
 * @property float $pressure
 * @property float $humidity
 * @property Location $location
 * @method static \Illuminate\Database\Eloquent\Builder|Forecast newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Forecast newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Forecast query()
 * @method static \Illuminate\Database\Eloquent\Builder|Forecast whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forecast whereForecastTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forecast whereHumidity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forecast whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forecast whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forecast wherePressure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forecast whereTempMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forecast whereTempMin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Forecast whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Forecast extends Model
{
    use HasFactory;

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id', 'id');
    }
}
