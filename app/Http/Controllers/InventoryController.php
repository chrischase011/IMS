<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        return view('inventory.index');
    }

    public function getProducts()
    {
        $res = Inventory::with(['product', 'warehouse'])->get();

        $data = [
            'data' => $res
        ];

        return response()->json($data);
    }   
}
