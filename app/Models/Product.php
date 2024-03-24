<?php

namespace App\Models;

use App\Enums\ProductStatusEnums;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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
 */
class Product extends Model
{

    use SoftDeletes;

    public $guarded = [];

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
            config('lunar.database.table_prefix').'collection_product'
        )->withPivot(['position'])->withTimestamps();
    }
}
