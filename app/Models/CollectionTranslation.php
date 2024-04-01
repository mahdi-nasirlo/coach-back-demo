<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $slug
 * @property string $name
 * @property string $description
 * @property string $url
 */
class CollectionTranslation extends Model
{
    protected $fillable = ["name", "description", "slug", "url"];

    public $timestamps = false;


}
