<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];


    protected $dates = [
        'created_at',
        'updated_at'
    ];

    public function rawMaterials()
    {
        return $this->hasMany(RawMaterial::class);
    }
}
