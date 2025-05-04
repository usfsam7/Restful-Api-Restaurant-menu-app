<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Restaurant extends Model
{
    /** @use HasFactory<\Database\Factories\RestaurantFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded =[];

    public function user(): BelongsTo
    {
        return  $this->belongsTo(User::class);
    }

    public static function booted(){
        parent::booted();
        static::saving (function ($restaurant) {
            $restaurant->slug = Str::slug($restaurant->name);
        });
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class,"imageable");
    }


    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }


    public function items(): HasManyThrough
    {
        return $this->hasManyThrough(Item::class, Category::class);
    }

}
