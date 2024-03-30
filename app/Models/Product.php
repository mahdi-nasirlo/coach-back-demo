<?php

namespace App\Models;

use App\Enums\ProductStatusEnums;
use App\Enums\ProductTypeEnums;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $attribute_data
 * @property ?string $sku
 * @property ProductStatusEnums $status
 * @property bool $shippable
 * @property int $stock
 * @property string $purchasable
 * @property User $user
 * @property ProductStatusEnums $product_type
 */
class Product extends Model
{

    use SoftDeletes;
    use Translatable;

    public array $translatedAttributes = ["name", "description", "attribute_data"];

    public $guarded = [];

    public $casts = [
        "product_type" => ProductTypeEnums::class
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function prices(): MorphMany
    {
        return $this->morphMany(
            Price::class,
            "priceable"
        );
    }

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(
            Collection::class,
            config('lunar.database.table_prefix') . 'collection_product'
        )->withPivot(['position'])->withTimestamps();
    }
}
