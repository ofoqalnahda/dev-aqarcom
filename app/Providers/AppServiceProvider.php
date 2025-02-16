<?php

namespace App\Providers;

use App\Models\PersonalAccessToken;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment('local') && config('telescope.enabled')) {
//            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        Gate::after(function ($user, $ability) {
            return $user->hasRole('super_admin'); // note this returns boolean
        });

        Paginator::useBootstrapFive();

        Builder::macro('whereRelationIn', function ($relation, $column, $data) {
            return $this->whereHas(
                $relation, fn($q) => $q->whereIn($column, $data)
            );

        });

        // check if route is api
        if(request()->is('api/*')){
            Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        }

        if (!app()->runningInConsole() && !app()->runningUnitTests() && !request()->is('api/*')) {
            // will not migrate if the database is not ready
//            view()->share('setting', Setting::first());
//            view()->share('sliders', Slider::all());


            view()->share('setting', Cache::remember("setting", env('CACHE_LONG_TIME', 60),
                fn() => Setting::first()
            ));
            view()->share('sliders', Cache::remember("sliders", env('CACHE_LONG_TIME', 60),
                fn() => Slider::all()
            ));
        }

    }
}
