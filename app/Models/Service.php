<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'price',
        'user_id',
        'coverage_range',
        'starting_point',
    ];
}
