<?php

namespace App\Helpers;

use App\Models\StockTransaction;
use Illuminate\Support\Facades\Auth;

class HandleStockTransaction
{
    public static function writeStockTransaction($id, $type, $quantityIn, $quantityOut, $transactionDate, $transactionType, $transactionOperation, $warehouse)
    {
        $stockTransactionRecord = new StockTransaction();
        $stockTransactionRecord->user_id = Auth::id();
        $stockTransactionRecord->transaction_date = $transactionDate;
        $stockTransactionRecord->transaction_type = $transactionType;
        $stockTransactionRecord->quantity_in = $quantityIn;
        $stockTransactionRecord->quantity_out = $quantityOut;
        $stockTransactionRecord->transaction_operation = $transactionOperation;
        $stockTransactionRecord->warehouse_id = $warehouse;

        switch($type)
        {
            case 'product':
                $stockTransactionRecord->product_id = $id;
            break;

            case 'raw':
                $stockTransactionRecord->raw_material_id = $id;
            break;
            
        }

        $stockTransactionRecord->save();
    }
}

?>