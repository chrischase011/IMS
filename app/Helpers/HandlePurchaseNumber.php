<?php

namespace App\Helpers;

use App\Models\RawMaterials;

class HandlePurchaseNumber
{
    public static function generate($id)
    {
        $raw = RawMaterials::find($id);

        if(!$raw->purchase_number)
        {
            $lastId = RawMaterials::latest('id')->first();

            if (!$lastId) {
                $nextId = 1;
            } else {
                $nextId = $lastId->id + 1;
            }

            $formattedId = str_pad($nextId, 2, '0', STR_PAD_LEFT);

            // Create the order number
            $purchase= "PUR-" . date('Y') . "-" . $formattedId;

            $raw->purchase_number = $purchase;
            $raw->save();

            return $purchase;
        }

        return $raw->purchase_number;

    }
}
