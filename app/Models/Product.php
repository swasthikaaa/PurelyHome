<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\OrderItem;


class Product extends Model
{
    use HasFactory;

    protected $connection = 'mysql'; 

    protected $fillable = [
        'category_id',
        'admin_id',
        'name',
        'slug',
        'description',
        'quantity',
        'price',
        'image',
        'offer_price',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * 🔗 Relation to OrderItems (MongoDB)
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'id')
            ->setConnection('mongodb');
    }
}
