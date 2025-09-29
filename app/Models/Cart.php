<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'carts';

    protected $fillable = [
        'user_id',
        'status',
    ];

    protected $casts = [
        '_id' => 'string',
    ];

    public function user()
    {
        // User is still MySQL (normal Eloquent)
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function cartItems()
    {
        // Match Mongo _id with cart_id field in cart_items
        return $this->hasMany(CartItem::class, 'cart_id', '_id');
    }
}
