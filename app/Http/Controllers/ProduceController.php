<?php

namespace App\Http\Controllers;

use App\Helpers\HandleLabelling;
use App\Helpers\HandleStockTransaction;
use App\Models\Inventory;
use App\Models\Products;
use App\Models\Warehouse;
use App\Models\WarehouseInventory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProduceController extends Controller
{
    public function index()
    {
        $products = Products::where(['availability' => 1])->orderBy('name', 'asc')->get();
        $warehouses = Warehouse::where(function($query) {
            $query->where('status', 1)
                ->where('type', 1);
        })->get();

        return view('activities.produce.index', ['products' => $products, 'warehouses' => $warehouses]);
    }

    public function produce(Request $request)
    {
        $id = $request->id;
        $quantityToProduce = $request->quantity;
        $warehouse = $request->warehouse_id;

        $product = Products::with('productRequirements.rawMaterial')->find($id);

        $deductions = [];

        foreach ($product->productRequirements as $requirement) {
            $rawMaterial = $requirement->rawMaterial;
            $requiredQuantity = $requirement->quantity * $quantityToProduce;

            if ($rawMaterial->quantity >= $requiredQuantity) {

                $rawMaterial->quantity -= $requiredQuantity;
                $rawMaterial->save();

                $deductions[] = [
                    'raw_material' => $rawMaterial->name,
                    'deducted_quantity' => $requiredQuantity,
                ];
            } else {
                return back()->with('error', 'Not enough raw material available');
            }
        }

        // Saving to inventory
        $existingInventory = Inventory::where('product_id', $product->id)
            ->where('warehouse_id', $warehouse)
            ->first();

        if ($existingInventory) {

            $existingInventory->current_quantity += $quantityToProduce;
            $existingInventory->save();
        } else {

            $inventoryRecord = new Inventory();
            $inventoryRecord->product_id = $product->id;
            $inventoryRecord->price = $product->price;
            $inventoryRecord->current_quantity = $quantityToProduce;
            $inventoryRecord->reorder_level = 0;
            $inventoryRecord->warehouse_id = $warehouse;
            $inventoryRecord->save();
        }

        HandleStockTransaction::writeStockTransaction($product->id, 'product', $quantityToProduce, null, Carbon::now(), 'stock-in', null, $warehouse);


        // deduction
        $messageDeduction = "<br>";

        foreach ($deductions as $deduction) {
            $messageDeduction .= "
            <span>" . $deduction['raw_material'] . ": " . $deduction['deducted_quantity'] . "</span><br>";
        }

        return back()->with('success', "Product production successful <br><br><span class=''>Deductions:</span>" . $messageDeduction);
    }
}
