<?php
/** @author: Adam Pawełczyk */

namespace App\System\MessageBus\Middleware;

use App\Modules\Shared\Bus\StampedMessage;
use App\System\MessageBus\Stamp\UserStamp;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserStampMiddleware implements BusMiddleware
{
    public function handle(object $message, Closure $next): mixed
    {
        if ($message instanceof StampedMessage) {
            foreach ($message->getStamps() as $stamp) {
                if ($stamp instanceof UserStamp) {
                    Log::log('info', 'UserStampMiddleware: Attempting to login user with UUID: ' . $stamp->userUuid);
                    // TODO: Implement a way to login user by UUID
                    //Auth::loginUsingId($stamp->userUuid);
                    break;
                }
            }
        }

        return $next($message);
    }
}
