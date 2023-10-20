<?php

namespace App\Helpers;

use App\Models\Orders;

class HandleTransactionNumber
{
    public static function generate()
    {
        $lastId = Orders::latest('id')->first();

        if (!$lastId) {
            $nextId = 1;
        } else {
            $nextId = $lastId->id + 1;
        }

        $formattedId = str_pad($nextId, 2, '0', STR_PAD_LEFT);

        // Create the order number
        $transaction = "TR-" . date('Y') . "-" . $formattedId;

        return $transaction;

    }
}

?>
