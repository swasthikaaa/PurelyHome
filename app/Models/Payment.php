<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'order_id',
        'amount',
        'method',
        'status',
        'transaction_ref',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    protected $casts = [
        'amount' => 'decimal:2',
    ];
}
