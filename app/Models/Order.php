<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'orders';

    protected $fillable = [
        'user_id',
        'order_date',
        'status',
    ];

    protected $casts = [
        '_id' => 'string',
        'order_date' => 'datetime',
    ];

    /**
     * Belongs to User (MySQL)
     * Laravel will automatically use the User model's MySQL connection.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Has many OrderItems (MongoDB)
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', '_id');
    }

    /**
     * One Payment per Order (MongoDB)
     */
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id', '_id');
    }
}
