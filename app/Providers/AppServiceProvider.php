<?php

namespace App\Providers;

use App\Models\Category;
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
        // Share active categories with store navigation and layout
        View::composer(['partials.navbar', 'partials.footer'], function ($view) {
            $navCategories = Category::where('status', 'active')->orderBy('id', 'asc')->get();
            $view->with('navCategories', $navCategories);
        });
    }
}
