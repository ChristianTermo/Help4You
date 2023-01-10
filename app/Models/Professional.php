<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Professional extends Model
{
    protected $guard_name = 'api';
    use HasFactory, HasRoles;
    protected $fillable = [
        'nome',
        'cognome',
        'telefono',
        'email',
        'password',
        'services',
        'role',
    ];
}
