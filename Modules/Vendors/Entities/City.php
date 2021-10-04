<?php

namespace Modules\Vendors\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Vendors\Database\factories\CityFactory;

class City extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return CityFactory::new();
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(State::class, 'country_id', 'id');
    }
}
