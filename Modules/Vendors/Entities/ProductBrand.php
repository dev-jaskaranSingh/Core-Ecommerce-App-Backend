<?php

namespace Modules\Vendors\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Vendors\Database\factories\ProductBrandFactory;

class ProductBrand extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return ProductBrandFactory::new();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }
}
