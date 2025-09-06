<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 👈 if you are using roles like admin/customer
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /* --------------------------
     | Eloquent Relationships
     |---------------------------
     */

    // ✅ One user can place many orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // ✅ One user can have one cart
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    // ✅ One user can have many payments (through orders)
    public function payments()
    {
        return $this->hasManyThrough(Payment::class, Order::class);
    }

}
