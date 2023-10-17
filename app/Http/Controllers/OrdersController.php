<?php

namespace App\Http\Controllers;

use App\Helpers\HandleInvoiceNumber;
use App\Helpers\HandleOrderNumber;
use App\Models\Inventory;
use App\Models\OrderDetails;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Roles;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function index($slug = null)
    {
        if ($slug == null)
            return view('orders.index', ['slug' => $slug]);

        $warehouse = Warehouse::where('slug', $slug)->first();

        if ($warehouse) {
            $orders = Orders::with('customers')->where('warehouse_id', $warehouse->id)->orderBy('id', 'desc')->get();
        } else {

            return abort(404);
        }

        return view('orders.index', ['orders' => $orders, 'slug' => $slug, 'warehouse' => $warehouse]);
    }

    public function createOrder($slug = '0')
    {

        $warehouse = null;

        if ($slug != '0') {
            $warehouse = Warehouse::where(function ($query) use ($slug) {
                $query->where('slug', $slug)
                    ->where('type', 2);
            })->first();
        }

        $warehouses = Warehouse::where('type', 2)->get();
        $roles = Roles::where('slug', 'customer')->first();
        $customers = User::where('roles', $roles->id)->get();

        if ($warehouse) {
            $products = Inventory::with('product')->where(function ($query) use ($warehouse) {
                $query->where('warehouse_id', $warehouse->id)
                    ->where('product_id', '!=', null);
            })->get();
        } else {
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

        $data = Inventory::with(['product'])->where(function ($query) use ($id) {
            $query->where('warehouse_id', $id);
        })->get();


        return $data;
    }

    public function submitOrder(Request $request)
    {
        $orderNumber = HandleOrderNumber::generate();
        $warehouse = Warehouse::find($request->warehouse_id);
        $order = Orders::create([
            'order_number' => $orderNumber,
            'order_date' => $request->order_date,
            'customer_id' => $request->customer_id,
            'shipping_address' => $request->shipping_address,
            'warehouse_id' => $request->warehouse_id,
            'printing_service' => $request->printing_services,
            'gross_amount' => $request->gross_amount,
            'vat' => $request->vat,
            'total_amount' => $request->total_amount
        ]);

        $lastOrder = $order->id;

        if ($lastOrder) {
            $products = $request->input('products');
            $quantities = $request->input('quantity');
            $prices = $request->input('price');

            // return count($products);

            for ($i = 0; $i < count($products); $i++) {

                $orderDetail = new OrderDetails();
                $orderDetail->order_id = $lastOrder;
                $orderDetail->product_id = $products[$i];
                $orderDetail->quantity = $quantities[$i];
                $orderDetail->unit_price = $prices[$i];
                $orderDetail->total_price = $prices[$i] * $quantities[$i];
                $orderDetail->save();


                $product = Inventory::where('product_id', $products[$i])->first();
                $product->current_quantity -= $quantities[$i];
                $product->save();
            }
        }

        return redirect()->route('orders.index', ['slug' => $warehouse->slug])->with('success', "New order <b>$orderNumber</b> has been added.");
    }


    public function viewOrder(Request $request)
    {
        $id = $request->id;

        $orders = Orders::with(['customers', 'orderDetails', 'products'])->find($id);

        return response()->json($orders);
    }


    public function generateInvoice($orderID)
    {

        $invoice_number = HandleInvoiceNumber::generate($orderID);
        $order = Orders::with(['customers', 'orderDetails', 'products'])->find($orderID);


        return view("orders.invoice", ['order' => $order, 'invoice_number' => $invoice_number]);

    }

    public function manageOrder(Request $request)
    {
        $id = $request->id;

        $order = Orders::find($id);
        $order->is_paid = $request->is_paid;
        $order->order_status = $request->order_status;
        $order->save();

        return back()->with('success', "Order Number <strong>$order->order_number</strong> has been updated successfully.");
    }

    public function ordersList()
    {
        if(!Auth::check())
            return redirect('/');

        if(Auth::check() && Auth::user()->roles != 3)
            return redirect('/');

        $orders = Orders::where('customer_id', Auth::id())->orderBy('id', 'desc')->get();

        return view('orders.orders', ['orders' => $orders]);
    }


    public function orderReceived(Request $request)
    {
        $id = $request->id;

        $order = Orders::find($id);

        $order->order_status = 3;
        $order->save();

        return 1;
    }
}
