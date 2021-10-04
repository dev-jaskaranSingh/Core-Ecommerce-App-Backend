<?php

namespace Modules\Vendors\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Vendors\Database\factories\StateFactory;

class State extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return StateFactory::new();
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class,'state_id','id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
}
