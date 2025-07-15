<?php

/** @author: Adam Pawełczyk */

namespace App\System\Providers;

use App\Modules\Shared\QueryBus;
use App\System\Console\BusDebugCommand;
use App\System\MessageBus\QueryBus as SystemQueryBus;
use Illuminate\Support\ServiceProvider;
use App\System\MessageBus\HandlerRegisterer;

class MessageBusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SystemQueryBus::class);
        $this->app->singleton(HandlerRegisterer::class);
    }

    public function boot(): void
    {
        $this->app->bind(QueryBus::class, SystemQueryBus::class);
        $this->app->make(HandlerRegisterer::class)->register();

        if ($this->app->runningInConsole()) {
            $this->commands([
                BusDebugCommand::class,
            ]);
        }
    }
}
