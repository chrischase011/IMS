<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];


    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function customers()
    {
        return $this->hasMany(User::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class);
    }

    public function products()
    {
        return $this->belongsToMany(Products::class, 'order_details', 'order_id', 'product_id')
            ->withPivot('quantity', 'unit_price', 'total_price');
    }

    
}
