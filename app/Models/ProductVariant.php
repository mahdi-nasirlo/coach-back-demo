<?php

namespace App\Models;

use App\Traits\HasPrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $product_id
 * @property array $attribute_data
 * @property ?string $tax_ref
 * @property int $unit_quantity
 * @property ?string $sku
 * @property bool $shippable
 * @property int $stock
 * @property int $backorder
 * @property string $purchasable
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 * @property ?Carbon $deleted_at
 */
class ProductVariant extends Model
{

    use HasPrice;
    
    protected $guarded = [];

    protected $casts = [
        'requires_shipping' => 'bool',
        'attribute_data' => "json",
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function values(): BelongsToMany
    {
        return $this->belongsToMany(
            ProductOptionValue::class,
            "product_option_value_product_variant",
            'variant_id',
            'value_id'
        )->withTimestamps();
    }

}
