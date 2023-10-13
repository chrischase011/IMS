<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use MediaCloud\Vendor\Google\Cloud\Storage\Connection\Rest;

class WarehouseController extends Controller
{
    public function index()
    {
        return view('warehouse.index');
    }

    public function store(Request $request)
    {
        $slug = trim(Str::lower($request->name));
        $slug = str_replace(" ", "-", $slug);

        $data = Warehouse::create([
            'name' => trim($request->name),
            'slug' => $slug,
            'status' => $request->status,
            'type' => $request->type
        ]);

        if($data)
            return back()->with('success', "New warehouse has been created.");

            return back()->with('error', "Unexpected error occurred");
    }

    public function getWarehouses()
    {
        $res = Warehouse::orderBy('name', 'asc')->get();

        $data = [
            'data' => $res
        ];

        return response()->json($data);
    }

    public function getWarehouse(Request $request)
    {
        $id = $request->id;

        $data = Warehouse::find($id);

        return response()->json($data);

    }

    public function update(Request $request)
    {
        $id = $request->id;

        $data = Warehouse::find($id);
        $data->name = $request->name;
        $data->type = $request->type;
        $data->status = $request->status;
        $data->save();

        return back()->with('success', "Warehouse has been updated.");
    }

    public function deleteWarehouse(Request $request)
    {
        $id = $request->id;

        $data = Warehouse::find($id);

        $data->delete();

        return response()->json($data);

    }
}
