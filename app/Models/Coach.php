<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int status
 */
class Coach extends Model
{
    use Translatable;

    public array $translatedAttributes = ["name", "education_record", "job_experience", "resume", "about_me"];

    protected $guarded = [];

}
