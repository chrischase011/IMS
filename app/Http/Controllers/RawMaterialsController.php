<?php

namespace App\Http\Controllers;

use App\Helpers\HandleStockTransaction;
use App\Models\RawMaterials;
use App\Models\Suppliers;
use App\Models\User;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RawMaterialsController extends Controller
{

    public function index()
    {
        $suppliers = Suppliers::all();
        $warehouses = Warehouse::where(function($query){
            $query->where('type', 1)
                ->where('status', 1);
        })->get();

        return view('raw_materials.index', ['suppliers' => $suppliers, 'warehouses' => $warehouses]);
    }

    public function create()
    {
        $suppliers = Suppliers::all();
        $warehouses = Warehouse::where(function($query){
            $query->where('type', 1)
                ->where('status', 1);
        })->get();
        return view('raw_materials.create', ['suppliers' => $suppliers, 'warehouses' => $warehouses]);
    }

    public function getRawMaterials()
    {
        $res = RawMaterials::with(['supplier', 'warehouse'])->orderBy('name', 'asc')->get();

        $data = [
            'data' => $res
        ];

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $desc = $request->description ? $request->description : "No Description";
        $data = RawMaterials::create([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'description' => $desc,
            'reorder_level' => $request->reorder_level,
            'supplier_id' => $request->supplier,
            'warehouse_id' => $request->warehouse,
            'availability' => $request->availability
        ]);

        if($data)

            HandleStockTransaction::writeStockTransaction($data->id,'raw', $request->quantity, null, Carbon::now(), 'stock-in', null, $request->warehouse);


            return back()->with('success', 'New Raw Material has been added.');
        return back()->with('error', 'Unexpected Error');
    }


    public function getRawMaterial(Request $request)
    {
        $id = $request->id;

        $data = RawMaterials::find($id);

        return response()->json($data);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $desc = $request->description ? $request->description : "No Description";
        $data = RawMaterials::find($id);

        $last_quantity = $data->quantity;

        $data->name = $request->name;
        $data->quantity = $request->quantity;
        $data->price = $request->price;
        $data->description = $desc;
        $data->reorder_level = $request->reorder_level;
        $data->supplier_id = $request->supplier;
        $data->availability = $request->availability;
        $data->save();

        if($last_quantity > $request->quantity)
        {
            $quantityOut = $last_quantity - $request->quantity;
            HandleStockTransaction::writeStockTransaction($id, 'raw', null, $quantityOut, Carbon::now(), 'stock-out', null, $data->warehouse_id);
        }

        if($request->quantity > $last_quantity)
        {
            $quantityIn = $request->quantity - $last_quantity;
            HandleStockTransaction::writeStockTransaction($id, 'raw', $quantityIn, null, Carbon::now(), 'stock-in', null, $data->warehouse_id);
        }


        return back()->with('success', 'Updated Successfully');
    }


    public function delete(Request $request)
    {
        $id = $request->id;

        $data = RawMaterials::find($id);

        if($data)
        {
            $data->delete();
        }

        return 1;
    }
}
