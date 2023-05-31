<?php
namespace Redlof\Core\ServiceProviders;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */

    public function register()
    {
        $this->app->register("Redlof\Core\ServiceProviders\RedlofMailServiceProvider");
    }

}
