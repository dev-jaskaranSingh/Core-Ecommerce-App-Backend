<?php

namespace Modules\Vendors\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Vendors\Http\Controllers\ProductVariantController;

class ProductCategoryVariant extends Model
{
    use HasFactory;

    protected $table = 'product_category_variant';
    protected $fillable = ['category_id','variant_id'];

    protected static function newFactory()
    {
        return ProductVariantFactory::new();
    }

    public function variant(){
        return $this->belongsTo(ProductVariant::class, 'variant_id', 'id');
    }

}
