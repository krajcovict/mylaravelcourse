<?php

namespace App\Providers;

// use App\Models\Model;

use App\Models\Car;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
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
        Paginator::defaultView('pagination');
        // Model::preventLazyLoading();

        Gate::define('update-car', function (User $user, Car $car) {
            return $user->id === $car->user_id;
        });
        Gate::define('delete-car', function (User $user, Car $car) {
            return $user->id === $car->user_id ? Response::allow()
        : Response::denyWithStatus(404);
        });
    }
}
