<?php

namespace Modules\Vendors\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Vendors\Database\factories\WishlistFactory;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = ['user_id ', 'product_id', 'status'];

    protected static function newFactory()
    {
        return WishlistFactory::new();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
