<?php

declare(strict_types=1);

namespace Wave;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    public $timestamps = false;

    protected $table = 'settings';

    protected $guarded = [];

    public static function get($key, $default = null)
    {
        $settings = Cache::rememberForever('wave_settings', function () {
            return self::pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('wave_settings');
        });

        static::deleted(function () {
            Cache::forget('wave_settings');
        });
    }
}
