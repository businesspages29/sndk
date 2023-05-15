<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    public function scopeParentNull($query): void
    {
        $query->whereNull('parent_id');
    }

    public function scopeParentId($query,$parent_id)
    {
        return $query->where('parent_id',$parent_id);
    }

    public function subcategory()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
