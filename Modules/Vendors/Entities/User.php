<?php

namespace Modules\Vendors\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Vendors\Database\factories\UserFactory;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mobile',
        'role_id',
        'email',
        'password',
        'notification_token',
        'country_id',
        'state_id',
        'city_id',
        'address',
        'locality_id',
        'status'
    ];

    protected static function newFactory()
    {
        return UserFactory::new();
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'role_id', 'id');
    }

    public function locality(): BelongsTo
    {
        return $this->belongsTo(Locality::class, 'locality_id  ', 'id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id ', 'id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class,'user_id','id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class,'user_id','id');
    }
}
