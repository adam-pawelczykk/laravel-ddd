<?php

/** @author: Adam Pawełczyk */

namespace App\System\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $discoverer = new ModuleServiceProviderDiscoverer();
        $providers = $discoverer->discover(base_path('app/Modules'));

        foreach ($providers as $providerClass) {
            if (class_exists($providerClass)) {
                $this->app->register($providerClass);
            }
        }
    }
}
