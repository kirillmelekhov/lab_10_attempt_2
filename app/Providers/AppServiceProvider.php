<?php

namespace App\Providers;

use App\Models\CreativeType;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::composer('*', function ($view): void {
            $menuCreativeTypes = collect();

            if (Schema::hasTable('creative_types')) {
                $menuCreativeTypes = CreativeType::query()
                    ->orderBy('name')
                    ->get();
            }

            $view->with('menuCreativeTypes', $menuCreativeTypes);
        });
    }
}
