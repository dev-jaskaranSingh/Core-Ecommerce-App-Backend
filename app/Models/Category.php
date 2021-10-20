<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    protected $table = "categories";
    protected $fillable = [
        'title',
        'description',
        'units',
        'vendor_id',
        'status'
    ];
}