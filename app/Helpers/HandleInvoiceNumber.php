<?php

namespace App\Helpers;

use App\Models\Orders;

class HandleInvoiceNumber
{
    public static function generate($orderID)
    {
        $order = Orders::find($orderID);

        if(!$order->invoice_number)
        {
            $lastId = Orders::latest('id')->first();

            if (!$lastId) {
                $nextId = 1;
            } else {
                $nextId = $lastId->id + 1;
            }

            $formattedId = str_pad($nextId, 2, '0', STR_PAD_LEFT);

            // Create the order number
            $invoice = "INV-" . date('Y') . "-" . $formattedId;

            $order->invoice_number = $invoice;
            $order->save();

            return $invoice;
        }

        return $order->invoice_number;

    }
}


?>
