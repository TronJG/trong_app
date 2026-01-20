<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsignmentAccount extends Model
{
    protected $fillable = ['code','price_k','segment','heroes','skins','note'];

    protected $casts = [
        'price_k' => 'integer',
        'heroes'  => 'integer',
        'skins'   => 'integer',
    ];

    public function images()
    {
        return $this->hasMany(ConsignmentImage::class);
    }

    public function getPriceVndAttribute(): int
    {
        return $this->price_k * 1000;
    }
}
