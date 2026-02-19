<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'shop_category_id',
        'city_id',
        'logo_path',
        'header_image_path',
        'discount_percent',
        'description',
        'map_embed',
    ];

    public function qrSessions()
    {
        return $this->hasMany(QrSession::class);
    }

    public function transactions()
    {
        return $this->hasMany(QrTransaction::class);
    }

    public function images()
    {
        return $this->hasMany(ShopImage::class)->orderBy('sort_order')->orderBy('id');
    }

    public function category()
    {
        return $this->belongsTo(ShopCategory::class, 'shop_category_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
