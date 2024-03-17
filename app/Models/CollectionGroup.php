<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $handle
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class CollectionGroup extends Model
{
    use Translatable;

    public array $translatedAttributes = ["name"];

    protected $guarded = [];

    public function collections(): HasMany
    {
        return $this->hasMany(Collection::class);
    }

}
