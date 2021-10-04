<?php

namespace Modules\Vendors\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Vendors\Database\factories\ProductCategoryFactory;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return ProductCategoryFactory::new();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
