<?php

namespace App\Helpers;

use App\Models\WarehouseInventory;

class HandleLabelling
{
    public static function generateProdLabel($warehouse_id)
    {
        $lastId = WarehouseInventory::latest('id')->first();

        if (!$lastId) {
            $nextId = 1;
        } else {
            $nextId = $lastId->id + 1;
        }

        $formattedId = str_pad($nextId, 2, '0', STR_PAD_LEFT);

        // Create the label
        $label = "PROD$warehouse_id-" . date('Y') . "-" . $formattedId;

        return $label;
    }

    public static function generateLogisticLabel($warehouse_id)
    {
        $lastId = WarehouseInventory::latest('id')->first();

        if (!$lastId) {
            $nextId = 1;
        } else {
            $nextId = $lastId->id + 1;
        }

        $formattedId = str_pad($nextId, 2, '0', STR_PAD_LEFT);

        
        $label = "LOG$warehouse_id-" . date('Y') . "-" . $formattedId;

        return $label;
    }
}
