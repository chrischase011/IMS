<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequirements extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];


    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterials::class);
    }
}
