<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\OpenRouterService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Contracts\SettingRepositoryInterface::class, \App\Repositories\SettingRepository::class);
        $this->app->singleton(\App\Contracts\AIChatServiceInterface::class, OpenRouterService::class);

        $this->app->singleton('settings', function () {
            return app(\App\Contracts\SettingRepositoryInterface::class)->getGlobalSettings();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Optimization: Use selective view names instead of '*'
        \Illuminate\Support\Facades\View::composer(['layouts.*', 'pages.*', 'catalog.*', 'home', 'admin.*', 'errors.*'], function ($view) {
            $view->with('global_setting', app('settings'));
            
            $categories = \Illuminate\Support\Facades\Cache::remember('categories_global', 3600, function() {
                return \App\Models\Category::all();
            });
            $view->with('global_categories', $categories);
        });
    }
}
