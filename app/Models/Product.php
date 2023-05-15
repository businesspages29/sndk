<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'options'
    ];

    protected $casts = [
        'options' => 'array',
    ];

    protected $appends = ['image_url'];


    public function getImageUrlAttribute()
    {
        $res = $this->hasMany(ProductImage::class)->first();
        if($res){
            return $res->image_url;
        }
        return asset('product.png');
    }

    public function scopeCategoryId($query,$category_id)
    {
        return $query->where('category_id',$category_id);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }    
}
