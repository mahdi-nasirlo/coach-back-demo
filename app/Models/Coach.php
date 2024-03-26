<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int id
 * @property string name
 * @property int status
 * @property string phone_number
 * @property string resume_file
 * @property string education_record
 * @property string job_experience
 * @property string resume
 * @property string about_me
 */
class Coach extends Model
{
    use Translatable, HasFactory;

    public array $translatedAttributes = ["name", "education_record", "job_experience", "resume", "about_me"];

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
