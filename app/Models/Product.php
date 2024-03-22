<?php

namespace App\Models;

use App\Enums\ProductStatusEnums;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property ProductStatusEnums $status
 * @property User $user
 */
class Product extends Model
{
    public $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
