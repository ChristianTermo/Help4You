<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'description',
        'category_id',
        'budget_min',
        'budget_max',
        'user_id',
        'attachments',
        'expiration',
    ];

    public static function getId($id)
    {
       $customerOrder = CustomerOrder::find($id);
    }
}
