<?php

/** @author: Adam Pawełczyk */

namespace App\System\Providers;

use App\Modules\Shared\Bus\CommandBus;
use App\Modules\Shared\Bus\EventBus;
use App\Modules\Shared\Bus\QueryBus;
use App\System\Console\BusDebugCommand;
use App\System\MessageBus\Bus\CommandBus as SystemCommandBus;
use App\System\MessageBus\Bus\EventBus as SystemEventBus;
use App\System\MessageBus\Bus\QueryBus as SystemQueryBus;
use App\System\MessageBus\HandlerRegisterer;
use App\System\MessageBus\Middleware\UserStampMiddleware;
use App\System\MessageBus\Policy\StampPolicy;
use Illuminate\Bus\Dispatcher as CommandDispatcher;
use Illuminate\Events\Dispatcher as EventDispatcher;
use Illuminate\Database\DatabaseTransactionsManager;
use Illuminate\Support\ServiceProvider;

class MessageBusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SystemQueryBus::class);
        $this->app->singleton(HandlerRegisterer::class);
    }

    public function boot(): void
    {
        $this->app->make(HandlerRegisterer::class)->register();

        // Register the system message bus implementations
        $this->app->singleton(QueryBus::class, SystemQueryBus::class);
        $this->app->singleton(CommandBus::class, function ($app) {
            return new SystemCommandBus(
                $app->make(CommandDispatcher::class),
                $app->make(DatabaseTransactionsManager::class),
                $app->make(StampPolicy::class),
                [
                    UserStampMiddleware::class,
                ]
            );
        });

        $this->app->singleton(EventBus::class, function ($app) {
            return new SystemEventBus(
                $app->make(EventDispatcher::class),
                $app->make(DatabaseTransactionsManager::class),
                $app->make(StampPolicy::class),
            );
        });

        if ($this->app->runningInConsole()) {
            $this->commands([
                BusDebugCommand::class,
            ]);
        }
    }
}
