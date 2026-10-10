<?php

namespace App\Providers;

use App\Contracts\AIChatServiceInterface;
use App\Contracts\SettingRepositoryInterface;
use App\Models\Category;
use App\Repositories\SettingRepository;
use App\Services\OpenRouterService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SettingRepositoryInterface::class, SettingRepository::class);
        $this->app->singleton(AIChatServiceInterface::class, OpenRouterService::class);

        $this->app->singleton('settings', function () {
            return app(SettingRepositoryInterface::class)->getGlobalSettings();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Optimization: Use selective view names instead of '*'
        View::composer(['layouts.*', 'pages.*', 'catalog.*', 'home', 'admin.*', 'errors.*'], function ($view) {
            $view->with('global_setting', app('settings'));

            $categories = Cache::remember('categories_global', 3600, function () {
                return Category::all();
            });
            $view->with('global_categories', $categories);
        });
    }
}
