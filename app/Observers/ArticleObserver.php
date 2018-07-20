<?php

namespace App\Observers;

use App\Models\Article;
use Cache;
use Carbon\Carbon;

class ArticleObserver
{
    public function saved(Article $article)
    {
//        article cache refresh
        $cacheKey = 'article_'.$article->slug;
        Cache::put($cacheKey,$article,43200);

//        latest_news cache refresh
//        $cacheKey = 'latest_articles';
//        $newCacheData = Article::where('published_at','<',Carbon::now())->orderBy('published_at', 'desc')->select('name','slug','image','excerpt','featured','published_at')->take(3)->get();
//        Cache::forever($cacheKey,$newCacheData);

//        featured_news cache refresh
//        $cacheKey = 'featured_news';
//        $newCacheData = Article::where('featured',1)->where('published_at','<',Carbon::now())->orderBy('published_at', 'desc')->select('name','slug','image','excerpt','featured','published_at')->take(4)->get();
//        Cache::forever($cacheKey,$newCacheData);

    }

    public function deleted(Article $article)
    {
        //        article cache deleted
        $cacheKey = 'article_'.$article->slug;
        $cacheData = Cache::tags('article')->get($cacheKey);
        if($cacheData){
            Cache::forget($cacheKey);
        }

//        latest_news cache refresh
//        $cacheKey = 'latest_articles';
//        $newCacheData = Article::where('published_at','<',Carbon::now())->orderBy('published_at', 'desc')->select('name','slug','image','excerpt','featured','published_at')->take(3)->get();
//        Cache::forever($cacheKey,$newCacheData);

//        featured_news cache refresh
//        $cacheKey = 'featured_news';
//        $newCacheData = Article::where('featured',1)->where('published_at','<',Carbon::now())->orderBy('published_at', 'desc')->select('name','slug','image','excerpt','featured','published_at')->take(4)->get();
//        Cache::forever($cacheKey,$newCacheData);
    }
}