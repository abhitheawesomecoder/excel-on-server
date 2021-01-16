<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\ViewComposers\MenuComposer;
use Modules\Contractorprofile\ViewComposers\ContractorMenuComposer;

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
        //Schema::defaultStringLength(191);

        \View::composer(
            'partial.left-sidebar',
            MenuComposer::class
        );

        \View::composer(
            'partial.left-sidebar',
            ContractorMenuComposer::class
        );
    }
}
