<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Product\Core\Application\DTO;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class NewProductDTO extends Data
{
    public function __construct(
        #[Required]
        public string  $name,
        public ?string $description,
        #[Required]
        public float   $price,
        public ?array  $tags = [],
    ) {
    }
}
