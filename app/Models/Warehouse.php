<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;


    protected $table = 'warehouse';

    protected $guarded = [
        'id'
    ];


    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function warehouseInventory()
    {
        return $this->hasMany(WarehouseInventory::class, 'warehouse_id');
    }

    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class, 'warehouse_id');
    }

    public function orders()
    {
        return $this->hasMany(Orders::class, 'warehouse_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}
