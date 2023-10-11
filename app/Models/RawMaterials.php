<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterials extends Model
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
        return $this->hasMany(Inventory::class, 'raw_material_id');
    }

    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class, 'raw_material_id');
    }

    public function warehouseInventory()
    {
        return $this->hasMany(WarehouseInventory::class, 'raw_material_id');
    }

    public function productRequirements()
    {
        return $this->hasMany(ProductRequirements::class, 'raw_material_id');
    }
    
    public function supplier()
    {
        return $this->belongsTo(Suppliers::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}
