<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Page;
use App\Models\Article;
use App\Models\Product;
use App\Models\Gallery;
use App\Models\ProductCategory;
use App\Observers\PageObserver;
use App\Observers\ArticleObserver;
use App\Observers\ProductObserver;
use App\Observers\GalleryObserver;
use TCG\Voyager\Models\Setting;
use App\Observers\SettingObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share('product_categories',ProductCategory::orderBy('order', 'asc')->get());
//        view()->share('avg_price',Product::avg('price'));

        Page::observe(PageObserver::class);
        Article::observe(ArticleObserver::class);
        Product::observe(ProductObserver::class);
        Gallery::observe(GalleryObserver::class);
//        Setting::observe(SettingObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
