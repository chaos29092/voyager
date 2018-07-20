<?php

namespace App\Observers;

use TCG\Voyager\Models\Setting;
use Cache;

class SettingObserver
{
    public function saved(Setting $setting)
    {
        $cacheKey = 'setting';
        Cache::forever($cacheKey,Setting::all());
    }

    public function deleted(Setting $setting)
    {
        $cacheKey = 'setting';
        Cache::forever($cacheKey,Setting::all());
    }
}