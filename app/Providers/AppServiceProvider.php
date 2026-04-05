<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\Spa;
use Illuminate\Support\Facades\Auth;
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
        View::composer('spa_owner.partials.sidebar', function ($view) {
            $newBookingsCount = 0;

            if (Auth::check() && Auth::user()->role === 'spa_owner') {
                $spaId = Spa::where('user_id', Auth::id())->value('id');

                if ($spaId) {
                    $newBookingsCount = Booking::where('spa_id', $spaId)
                        ->where('status', 'pending')
                        ->count();
                }
            }

            $view->with('newBookingsCount', $newBookingsCount);
        });
    }
}
