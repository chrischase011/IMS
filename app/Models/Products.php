<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];


    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'product_id');
    }

    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class, 'product_id');
    }

    public function warehouseInventory()
    {
        return $this->hasMany(WarehouseInventory::class, 'product_id');
    }

    public function productRequirements()
    {
        return $this->hasMany(ProductRequirements::class, 'product_id');
    }
}
