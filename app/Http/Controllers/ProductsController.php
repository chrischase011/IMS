<?php

namespace App\Http\Controllers;

use App\Models\ProductRequirements;
use App\Models\Products;
use App\Models\RawMaterials;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        $rawMaterials = RawMaterials::where(['availability' => 1])->get();

        return view('products.index', ['rawMaterials' => $rawMaterials]);
    }

    public function store(Request $request)
    {
        $rawIDs = $request->raw_materials_id;
        $desc = $request->description ? $request->description : "No Description";
        $product = Products::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $desc,
            'availability' => $request->availability
        ]);

        $rawArray = explode(',', $rawIDs);

        foreach ($rawArray as $value) {
            $quantity = $request['quantity' . $value];

            ProductRequirements::create([
                'product_id' => $product->id,
                'raw_material_id' => $value,
                'quantity' => $quantity
            ]);
        }


        return back()->with('success', 'New Product has been added');
    }

    public function getProducts()
    {
        $res = Products::orderBy('name', 'asc')->get();

        $data = [
            'data' => $res
        ];

        return response()->json($data);
    }


    public function getProduct(Request $request)
    {
        $id = $request->id;

        $product = Products::with('productRequirements.rawMaterial')->find($id);

        $rawMaterialIds = $product->productRequirements->pluck('raw_material_id')->toArray();


        $rawMaterials = RawMaterials::whereNotIn('id', $rawMaterialIds)->get();

        $responseData = [
            'product' => $product,
            'rawMaterials' => $rawMaterials,
        ];

        return response()->json($responseData);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $rawIDs = explode(',', $request->raw_materials_id);
        $rawIDs = array_map('intval', $rawIDs);

        $prodReqIDs = explode(',', $request->product_requirements_id);
        $prodReqIDs = array_map('intval', $prodReqIDs);

        $desc = $request->description ? $request->description : "No Description";

        $product = Products::find($id);
        
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $desc;
        $product->availability = $request->availability;

        $product->save();

        $existingProductRequirements = $product->productRequirements;

       
        foreach ($existingProductRequirements as $requirement) {
            if (!in_array($requirement->raw_material_id, $rawIDs) || !in_array($requirement->id, $prodReqIDs)) {
                $requirement->delete();
            } else {

                $newQuantity = $request->input("editQuantity$requirement->id");
                if ($newQuantity !== $requirement->quantity) {
                    $requirement->quantity = $newQuantity;
                    $requirement->save();
                }
            }
        }

        foreach ($rawIDs as $rawMaterialId) {
            if (!in_array($rawMaterialId, $prodReqIDs)) {
                // Check if a product requirement with this raw_material_id already exists.
                $existingRequirement = $existingProductRequirements->where('raw_material_id', $rawMaterialId)->first();
    
                if (!$existingRequirement) {
                    // Create a new product requirement if it doesn't exist.
                    ProductRequirements::create([
                        'product_id' => $product->id,
                        'raw_material_id' => $rawMaterialId,
                        'quantity' => $request->input("editQuantity$rawMaterialId") // Adjust this as needed.
                    ]);
                }
            }
        }

        return back()->with('success', 'Product has been updated successfully.');
    }


    public function deleteProduct(Request $request)
    {
        $id = $request->id;

        $product = Products::find($id);

        $product->delete();

        return 1;
    }
}
