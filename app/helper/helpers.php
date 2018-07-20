<?php
use App\Models\Page;
use App\Models\Article;
use App\Models\Product;
use Carbon\Carbon;

//if (!function_exists('image_small')) {
//    function image_small($image)
//    {
//        $image_small_path = null;
//        if ($image){
//            $image_path = pathinfo($image);
//            $image_small_path =  $image_path['dirname']."/".$image_path['filename']."-small.".$image_path['extension'];
//        }
//
//        return $image_small_path;
//    }
//}

//Page Cache ,use slug
if (!function_exists('page_cache')) {
    function page_cache($page_id)
    {
        $cache_key = 'page_'.$page_id;
        $cache_data = Cache::get($cache_key);
        if (!$cache_data){
            $cache_data = Page::find($page_id);
            Cache::forever($cache_key,$cache_data);
        }
        return $cache_data;
    }
}

//Article Cache
if (!function_exists('article_cache')) {
    function article_cache($article_slug)
    {
        $cache_key = 'article_'.$article_slug;
        $cache_data = Cache::get($cache_key);
        if (!$cache_data){
            $cache_data = Article::whereSlug($article_slug)->firstOrFail();
            Cache::put($cache_key,$cache_data,43200);
        }
        return $cache_data;
    }
}

if (!function_exists('latest_articles_cache')) {
    function latest_articles_cache()
    {
        $cache_key = 'latest_articles';
        $cache_data = Cache::get($cache_key);
        if(!$cache_data){
            $cache_data = Article::where('published_at','<',Carbon::now())->orderBy('published_at', 'desc')->select('name','slug','image','excerpt','featured','published_at')->take(3)->get();
            Cache::forever($cache_key,$cache_data);
        }

        return $cache_data;
    }
}

//Product Cache
if (!function_exists('product_cache')) {
    function product_cache($product_slug)
    {
        $cache_key = 'product_'.$product_slug;
        $cache_data = Cache::get($cache_key);
        if (!$cache_data){
            $cache_data = Product::whereSlug($product_slug)->firstOrFail();
            Cache::put($cache_key,$cache_data,43200);
        }

        return $cache_data;
    }
}

if (!function_exists('products_cache')) {
    function products_cache()
    {
        $cache_key = 'products';
        $cache_data = Cache::get($cache_key);
        if (!$cache_data){
            $cache_data = Product::with('productCategory')->orderBy('order', 'asc')->select('name','price','product_code','product_category_id','slug','image','order')->get();
            Cache::forever($cache_key,$cache_data);
        }

        return $cache_data;
    }
}

if (!function_exists('featured_products_cache')) {
    function featured_products_cache()
    {
        $cache_key = 'featured_products';
        $cache_data = Cache::get($cache_key);
        if(!$cache_data){
            $cache_data = Product::whereFeatured(1)->orderBy('order', 'asc')->select('name','price','product_code','slug','image','order','featured')->take(4)->get();
            Cache::forever($cache_key,$cache_data);
        }

        return $cache_data;
    }
}
