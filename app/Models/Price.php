<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $priceable_type
 * @property int $priceable_id
 * @property int $price
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class Price extends Model
{
    protected $guarded = [];

    public function priceable(): MorphTo
    {
        return $this->morphTo();
    }
}
