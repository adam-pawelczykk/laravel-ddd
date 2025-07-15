<?php

/** @author: Adam Pawełczyk */

namespace App\Modules\Product\Core\Infrastructure\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductModel
 * @package App\Modules\Product\Core\Infrastructure\Eloquent
 *
 * @property string $uuid
 * @property string $name
 * @property string|null $description
 * @property float $price
 * @property array|null $tags
 *
 * @method static static create(array $attributes = [])
 * @method static Builder where(string $column, $operator = null, $value = null, $boolean = 'and')
 */
class ProductModel extends Model
{
    protected $table = 'products';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'uuid';

    protected $fillable = [
        'uuid',
        'name',
        'description',
        'price',
        'tags',
    ];

    protected $casts = [
        'tags' => 'array',
        'price' => 'float',
    ];
}
