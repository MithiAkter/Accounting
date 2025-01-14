<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment'; // Table name
    protected $fillable = [
        'customer_id',
        'product_id',
        'due_payment',
        'new_payment',
    ];
}