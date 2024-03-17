<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoachTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ["name","education_record", "job_experience", "resume", "about_me"];
}
