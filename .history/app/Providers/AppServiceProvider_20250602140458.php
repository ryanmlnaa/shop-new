<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\TblCart;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
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
        View::composer('*', function ($view) {
        $cartItems = TblCart::where([
            ['idUser', '=', 'guest123'],
            ['status', '=', 0]
        ])->get();

        $view->with('cartItems', $cartItems);
    });
    }
}
