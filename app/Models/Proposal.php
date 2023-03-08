<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'price', 'description', 'from_user', 'to_user', 'delivery_time', 'is_accepted', 'id_order'
    ];
}
