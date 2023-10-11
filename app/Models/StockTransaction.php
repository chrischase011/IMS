<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    use HasFactory;

    protected $table = 'stock_transaction';

    protected $guarded = [
        'id'
    ];


    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterials::class, 'raw_material_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}
