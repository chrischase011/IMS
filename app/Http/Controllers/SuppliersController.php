<?php

namespace App\Http\Controllers;

use App\Models\Suppliers;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    public function index()
    {
        return view('suppliers.index');
    }

    public function getSuppliers()
    {
        $res = Suppliers::all();

        $data = [
            'data' => $res
        ];

        return response()->json($data);
    }

    public function store(Request $request)
    {
        Suppliers::create($request->all());

        return back()->with('success', 'New Supplier has been added.');
    }

    public function getSupplier(Request $request)
    {
        $id = $request->id;

        $supplier = Suppliers::find($id);

        return response()->json($supplier);
    }

    public function update(Request $request)
    {
        $id = $request->id;

        $supplier = Suppliers::find($id);
        $supplier->update($request->all());

        $supplier->save();

        return back()->with('success', 'Supplier has been updated.');
    }
}
