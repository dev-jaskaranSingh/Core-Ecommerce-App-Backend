<?php

namespace Modules\Vendors\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Vendors\Database\factories\UserRoleFactory;

class UserRole extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'status'];

    protected static function newFactory()
    {
        return UserRoleFactory::new();
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
