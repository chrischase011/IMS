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
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'order_id');
    }

    public function products()
    {
        return $this->belongsToMany(Products::class, 'order_details', 'order_id', 'product_id')
            ->withPivot('quantity', 'unit_price', 'total_price');
    }


    public function warehouses()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }


}
