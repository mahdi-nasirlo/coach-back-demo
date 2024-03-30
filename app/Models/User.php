<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Coach $coach
 * @property HasManyThrough $prices
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function coach(): HasOne
    {
        return $this->hasOne(Coach::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function prices(): HasManyThrough
    {
        return $this->hasManyThrough(related: Price::class, through: Product::class, secondKey: "priceable_id")
            ->where("priceable_type", Product::class)
            ->where("locale", app()->getLocale())
            ->select(
                "collection_translations.name",
                "collection_translations.collection_id",
                "prices.attribute_data",
                "prices.price",
                "prices.priceable_id as meeting_id"
            )
            ->join("collection_product", "collection_product.product_id", "=", "products.id")
            ->join("collection_translations", "collection_translations.collection_id", "=" , "collection_product.collection_id");
    }

    public function collections(): HasManyThrough
    {
        return $this->hasManyThrough(related: Collection::class, through: Product::class);
    }
}
