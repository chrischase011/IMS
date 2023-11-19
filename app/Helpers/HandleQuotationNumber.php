<?php

namespace App\Helpers;

use App\Models\Orders;

class HandleQuotationNumber
{
    public static function generate($orderID)
    {
        $order = Orders::find($orderID);

        if (!$order->quotation_number) {
            $lastId = Orders::latest('id')->first();

            if (!$lastId) {
                $nextId = 1;
            } else {
                $nextId = $lastId->id + 1;
            }

            $formattedId = str_pad($nextId, 2, '0', STR_PAD_LEFT);

            // Create the order number
            $quotation = "QUO-" . date('Y') . "-" . $formattedId;

            $order->quotation_number = $quotation;
            $order->save();

            return $quotation;
        }

        return $order->quotation_number;
    }
}
