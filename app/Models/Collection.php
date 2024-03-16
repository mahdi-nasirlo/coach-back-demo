<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property int $collection_group_id
 * @property-read  int $_lft
 * @property-read  int $_rgt
 * @property ?int $parent_id
 * @property string $type
 * @property ?array $attribute_data
 * @property string $sort
 * @property ?\Illuminate\Support\Carbon $created_at
 * @property ?\Illuminate\Support\Carbon $updated_at
 * @property ?\Illuminate\Support\Carbon $deleted_at
 */
class Collection extends Model
{
    protected $casts = [
        'attribute_data' => "json",
    ];

    protected $guarded = [];

    public function group(): BelongsTo
    {
        return $this->belongsTo(CollectionGroup::class, 'collection_group_id');
    }

    public function scopeInGroup(Builder $builder, int $id): Builder
    {
        return $builder->where('collection_group_id', $id);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            "collection_product"
        )->withPivot([
            'position',
        ])->withTimestamps()->orderByPivot('position');
    }
}
