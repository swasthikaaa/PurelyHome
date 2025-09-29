<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'payments';

    protected $fillable = [
        'order_id',
        'user_id',
        'amount',
        'method',
        'status',
        'transaction_id',
        'address',
        'zip',
        'phone',
        'name',
        'email',
        'city',
        'state',
        'notes',
    ];

    protected $casts = [
        '_id'        => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
