<?php

namespace App\Observers;

use App\Models\Page;
use Cache;

class PageObserver
{
    public function saved(Page $page)
    {
        $cacheKey = 'page_'.$page->id;
        Cache::forever($cacheKey,$page);
    }

    public function deleted(Page $page)
    {
        $cacheKey = 'page_'.$page->slug;
        $cacheData = Cache::get($cacheKey);
        if($cacheData){
            Cache::forget($cacheKey);
        }
    }
}