<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product;
use App\Models\Order;

class OrderItem extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'order_items';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        '_id' => 'string',
    ];

    /**
     * Belongs to Order (MongoDB)
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', '_id');
    }

    /**
     * Belongs to Product (MySQL)
     * Will use Product::$connection = 'mysql'
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
