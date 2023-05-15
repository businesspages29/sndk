<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'image',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        if(!empty($this->image)){
            return asset('storage/products/'.$this->image);
        }
        return asset('product.png');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }    
}
