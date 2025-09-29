<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;

    protected $connection = 'mongodb';
    protected $collection = 'cart_items';

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];

    protected $casts = [
        '_id'      => 'string',
        'cart_id'  => 'string',
        'quantity' => 'integer',
    ];

    /**
     * Relation to Cart (MongoDB)
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id', '_id');
    }

    /**
     * Accessor for Product (MySQL)
     * We don’t use belongsTo here because it’s in a different DB connection.
     */
    public function getProductAttribute()
    {
        return \App\Models\Product::find($this->product_id);
    }
}
