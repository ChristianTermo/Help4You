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
        'coverage_range',
        'starting_point',
    ];

    public function courses()
    {
        return $this->belongsToMany(User::class);
    }
}
