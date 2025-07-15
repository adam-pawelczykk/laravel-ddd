<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Shared;

interface QueryBus
{
    public function query(object $query): mixed;
}
