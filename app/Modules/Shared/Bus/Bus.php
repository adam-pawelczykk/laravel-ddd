<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Shared\Bus;

interface Bus
{
    public function dispatch(object $message, array $stamps = []): void;
    public function dispatchAfterCurrentStamp(object $message, array $stamps = []): void;
}
