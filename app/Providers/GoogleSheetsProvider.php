<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\GoogleSheets;


class GoogleSheetsProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GoogleSheets::class, function ($app) {
            return new GoogleSheets(config('redesul.google_sheet_id'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
