<?php

namespace Modules\Vendors\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Vendors\Database\factories\LocalityFactory;

class Locality extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return LocalityFactory::new();
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'locality_id', 'id');
    }
}
