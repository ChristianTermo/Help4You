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
        'category',
        'budget_min',
        'budget_max',
        'user_id',
        'attachments'
    ];

    public static function getId($id)
    {
       $customerOrder = CustomerOrder::find($id);
    }
}
