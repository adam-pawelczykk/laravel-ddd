<?php
/** @author: Adam Pawełczyk */

namespace App\System\MessageBus\Middleware;

use Closure;

interface BusMiddleware
{
    public function handle(object $message, Closure $next): mixed;
}
