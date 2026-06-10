<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Contracts\SettingRepositoryInterface::class, \App\Repositories\SettingRepository::class);
        $this->app->singleton(\App\Contracts\AIChatServiceInterface::class, \App\Services\GeminiService::class);

        $this->app->singleton('settings', function () {
            return app(\App\Contracts\SettingRepositoryInterface::class)->getGlobalSettings();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Optimization: Use selective view names instead of '*'
        \Illuminate\Support\Facades\View::composer(['layouts.*', 'pages.*', 'catalog.*', 'home', 'admin.*'], function ($view) {
            $view->with('global_setting', app('settings'));
            
            $categories = \Illuminate\Support\Facades\Cache::remember('categories_global', 3600, function() {
                return \App\Models\Category::all();
            });
            $view->with('global_categories', $categories);
        });
    }
}
