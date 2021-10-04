<?php

namespace Modules\Vendors\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Vendors\Database\factories\PaymentMethodFactory;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return PaymentMethodFactory::new();
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
