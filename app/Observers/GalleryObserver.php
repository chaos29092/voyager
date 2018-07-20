<?php

namespace App\Observers;

use App\Models\Gallery;
use Cache;

class GalleryObserver
{
    public function saved(Gallery $gallery)
    {
//        gallery_cache refresh
        $cacheKey = 'gallery_'.$gallery->slug;
        Cache::put($cacheKey,$gallery,43200);


//        galleries_cache refresh
//        $cacheKey = 'galleries';
//        $newCacheData = Gallery::with('galleryCategory')->get();
//        Cache::forever($cacheKey,$newCacheData);
    }

    public function deleted(Gallery $gallery)
    {
        //        article cache deleted
        $cacheKey = 'gallery_'.$gallery->slug;
        $cacheData = Cache::tags('gallery')->get($cacheKey);
        if($cacheData){
            Cache::forget($cacheKey);
        }

//        galleries_cache refresh
//        $cacheKey = 'galleries';
//        $newCacheData = Gallery::with('galleryCategory')->get();
//        Cache::forever($cacheKey,$newCacheData);
    }
}