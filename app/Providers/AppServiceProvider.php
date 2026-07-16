<?php

namespace App\Providers;

use App\Models\Pin;
use Illuminate\Support\Facades\View;
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
        View::composer(['partials.filter-bar', 'pins.create'], function ($view) {
        $view->with([
                'categories' => Pin::where('is_public', true)->distinct()->pluck('category'),
                'vibeTags'   => Pin::where('is_public', true)->whereNotNull('vibe_tag')->distinct()->pluck('vibe_tag'),
            ]);
        });
    }
}
