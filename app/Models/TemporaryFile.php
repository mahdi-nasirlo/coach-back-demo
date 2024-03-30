<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $folder
 * @property string $filename
 * @property string $file_type
 * @property string $filePath
 */
class TemporaryFile extends Model
{
    protected $guarded = [];

    public static array $imageTypes = ["png", "jpeg", "gif"];

    public function scopeImage(Builder $query): void
    {
        $query->whereIn("file_type", self::$imageTypes);
    }

    public function filePath(): Attribute
    {
        return new Attribute(get: fn() => "tmp\\" . $this->folder . "\\" . $this->filename);
    }

    public function absolutFilePath(): string
    {
        return storage_path("app\public\\" . $this->filePath);
    }
}
