<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Roles;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index($slug = null)
    {   
        if($slug == null)
            return view('orders.index', ['slug' => $slug]);
        
        $warehouse = Warehouse::where('slug', $slug)->first();

        if ($warehouse) {
            $orders = $warehouse->orders;
        } else {
            
            return abort(404);
        }

        return view('orders.index', ['orders' => $orders, 'slug' => $slug]);
    }

    public function createOrder($slug = '0')
    {

        $warehouse = null;
        
        if($slug != '0')
        {
            $warehouse = Warehouse::where(function($query) use ($slug){
                $query->where('slug', $slug)
                    ->where('type', 2);
            })->first();

        }
            
        $warehouses = Warehouse::where('type', 2)->get();
        $roles = Roles::where('slug', 'customer')->first();
        $customers = User::where('roles', $roles->id)->get();

        if($warehouse)
        {
            $products = Inventory::with('product')->where(function($query) use($warehouse){
                $query->where('warehouse_id', $warehouse->id)
                    ->where('product_id', '!=', null);
            })->get();
        }
        else{
            $products = Inventory::with('product')->where('product_id', '!=', null)->get();
        }
        
        return view('orders.create', ['warehouses' => $warehouses, 'warehouse' => $warehouse, 'customers' => $customers, 'products' => $products, 'slug' => $slug]);
    }


    public function getCustomer(Request $request)
    {
        $id = $request->id;

        $data = User::findOrFail($id);

        return $data;
    }

    public function getProductsByWarehouse(Request $request)
    {
        $id = $request->id;

        $data = Inventory::with(['product'])->where(function($query) use($id){
            $query->where('warehouse_id', $id);
        })->get();


        return $data;
    }
}
