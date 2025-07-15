<?php

/** @author: Adam Pawełczyk */

namespace App\System\MessageBus;

class HandlerPathProvider
{
    public function all(): array
    {
        return [
            app_path('System'),
            app_path('Modules'),
        ];
    }
}
