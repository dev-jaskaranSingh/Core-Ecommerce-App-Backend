<?php

namespace Modules\Vendors\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Vendors\Database\factories\CountryFactory;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return CountryFactory::new();
    }

    public function states(): HasMany
    {
        return $this->hasMany(State::class,'country_id','id');
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class,'country_id','id');
    }
}
