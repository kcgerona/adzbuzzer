<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use App\Contracts\Security\JWTSSO;
use App\Services\ZendeskService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->bindServices();
    }

    /**
     * Bind contracts with services
     */
    protected function bindServices()
    {
        $services = [
            JWTSSO::class => ZendeskService::class,
        ];

        foreach ($services as $contract => $service) {
            $this->app->bind($contract, $service);
        }
    }
}
