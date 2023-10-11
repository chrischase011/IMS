<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseInventory extends Model
{
    use HasFactory;

    protected $table = 'warehouse_inventory';

    protected $guarded = [
        'id'
    ];


    protected $dates = [
        'created_at',
        'updated_at'
    ];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class, 'raw_material_id');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }
}
