<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
}
