<?php

namespace Modules\Vendors\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Vendors\Database\factories\ProductFactory;

class Product extends Model
{
    use HasFactory;

    protected $appends = ['category_name'];

    protected $hidden = ['category', 'category_id', 'variant_id', 'deleted_at', 'status', 'updated_at'];

    protected $fillable = ['images', 'title', 'sale_price', 'purchase_price', 'description', 'unit', 'variant_id', 'category_id', 'status'];

    protected static function newFactory()
    {
        return ProductFactory::new();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(ProductBrand::class, 'brand_id', 'id');
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(ProductColor::class, 'color_id', 'id');
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id', 'id');
    }

    public function productStatus(): BelongsTo
    {
        return $this->belongsTo(ProductStatus::class, 'product_status_id', 'id');
    }

    public function getImagesAttribute($value)
    {
        return json_decode($value, true);
    }
    
    public function getCategoryNameAttribute($value)
    {
        return $this->category->title;
    }

}
