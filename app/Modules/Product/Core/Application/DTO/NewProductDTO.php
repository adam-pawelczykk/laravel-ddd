<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Product\Core\Application\DTO;

use Spatie\LaravelData\Data;

class NewProductDTO extends Data
{
    public function __construct(
        public string  $name,
        public ?string $description,
        public float   $price,
        public ?array  $tags = [],
    ) {
    }
}
