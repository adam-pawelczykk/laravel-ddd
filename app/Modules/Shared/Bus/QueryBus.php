<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Shared\Bus;

interface QueryBus
{
    public function query(object $query): mixed;
}
