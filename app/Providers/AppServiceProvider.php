<?php

namespace App\Providers;

use App\Models\CollectionTranslation;
use App\Observers\CollectionTranslationObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        CollectionTranslation::observe(CollectionTranslationObserver::class);
    }
}
