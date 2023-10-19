<?php

namespace App\Http\Controllers;

use App\Helpers\HandleStockTransaction;
use App\Models\Inventory;
use App\Models\RawMaterials;
use App\Models\StockTransaction;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WarehouseInventoryController extends Controller
{
    public function index()
    {
        return view('warehouse_inventory.index');
    }

    public function manage($slug)
    {
        $warehouse = Warehouse::with('warehouseInventory')->where(function ($query) use ($slug) {
            $query->where('slug', $slug)
                ->where('status', 1);
        })->firstOrFail();

        $stockIn = StockTransaction::with(['product', 'rawMaterial'])->where(function ($query) use ($warehouse) {
            $query->where('transaction_type', 'stock-in')
                ->where('warehouse_id', $warehouse->id);
        })->orderBy('transaction_date', 'desc')->get();

        $stockOut = StockTransaction::with(['product', 'rawMaterial'])->where(function ($query) use ($warehouse) {
            $query->where('transaction_type', 'stock-out')
                ->where('warehouse_id', $warehouse->id);
        })->orderBy('transaction_date', 'desc')->get();


        $products = Inventory::with('product')->where('warehouse_id', $warehouse->id)->get();
        $rawMaterials = RawMaterials::with('warehouse')->where('warehouse_id', $warehouse->id)->get();

        // return $products;

        // $stockInByProduct = $stockIn->groupBy('product_id');
        // $stockOutByProduct = $stockOut->groupBy('product_id');

        $stocks = [
            'stockIn' => $stockIn,
            'stockOut' => $stockOut,
        ];

        // return $stocks;
        return view('warehouse_inventory.manage', ['warehouse' => $warehouse, 'stocks' => $stocks, 'products' => $products, 'slug' => $slug, 'rawMaterials' => $rawMaterials]);
    }

    public function inventory($slug)
    {
        $warehouse = Warehouse::with('warehouseInventory')->where(function ($query) use ($slug) {
            $query->where('slug', $slug)
                ->where('status', 1);
        })->firstOrFail();

        $logistics = Warehouse::where('type', 2)->get();

        return view('warehouse_inventory.inventory', ['warehouse' => $warehouse, 'slug' => $slug, 'logistics' => $logistics]);
    }

    public function getProducts($slug)
    {
        $warehouse = Warehouse::with('warehouseInventory')->where(function ($query) use ($slug) {
            $query->where('slug', $slug)
                ->where('status', 1);
        })->firstOrFail();

        $res = Inventory::with(['product', 'warehouse'])->where(function ($query) use ($warehouse) {
            $query->where('warehouse_id', $warehouse->id);
        })->get();

        $data = [
            'data' => $res
        ];

        return response()->json($data);
    }


    public function getProduct(Request $request)
    {
        $id = $request->id;

        $res = Inventory::find($id);

        return response()->json($res);
    }

    public function manageInventory(Request $request)
    {
        $id = $request->id;

        $data = Inventory::findOrFail($id);

        $data->reorder_level = $request->reorder_level;
        $data->price = $request->price;

        $data->save();

        return back()->with('success', 'Updated Successfully');
    }

    public function deleteInventory(Request $request)
    {
        $id = $request->id;

        $data = Inventory::findOrFail($id);

        $data->delete();

        return 1;
    }


    public function moveToLogisticWarehouse(Request $request)
    {
        $id = $request->id;
        $currentWarehouseId = $request->current_warehouse;
        $destinationWarehouseId = $request->warehouse;

        // Get the inventory data to be moved
        $data = Inventory::find($id);

        // Check if the destination warehouse already has this product
        $destinationInventory = Inventory::where('product_id', $data->product_id)
            ->where('warehouse_id', $destinationWarehouseId)
            ->first();

        if ($destinationInventory) {
            // If the product already exists in the destination warehouse, update the quantity
            $destinationInventory->current_quantity += $data->current_quantity;
            $destinationInventory->save();
        } else {
            // If the product doesn't exist in the destination warehouse, create a new inventory record
            Inventory::create([
                'product_id' => $data->product_id,
                'warehouse_id' => $destinationWarehouseId,
                'price' => $data->price, // You might need to adjust this depending on your data
                'current_quantity' => $data->current_quantity,
                'reorder_level' => 0, // Adjust this as needed
            ]);
        }

        // Now that the data is moved, delete the inventory from the current warehouse
        $data->delete();

        HandleStockTransaction::writeStockTransaction($data->product_id, 'product', $data->current_quantity, null, Carbon::now(), 'stock-out', $request->transaction_operation, $request->current_warehouse);

        HandleStockTransaction::writeStockTransaction($data->product_id, 'product', $data->current_quantity, null, Carbon::now(), 'stock-in', $request->transaction_operation, $request->warehouse);

        return back()->with("success", 'Successfully moved to designated Logistic Warehouse.');
    }
}
