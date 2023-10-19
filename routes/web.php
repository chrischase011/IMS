<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ManagementController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProduceController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RawMaterialsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\UserLogController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\WarehouseInventoryController;
use App\Models\Suppliers;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\WarehouseInventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

Auth::routes();

Route::post('/registerUser', [RegisterController::class, 'registerUser'])->name("auth.registerUser");

Route::get('verify/{email}/{token}', [ManagementController::class, 'verifyEmail'])->name('management.verifyEmail');

// For Products
Route::group(['prefix' => 'products'], function(){
    Route::get('/', [ProductsController::class, 'index'])->name('products.index');
    Route::post('store', [ProductsController::class, 'store'])->name('products.store');
    Route::post('getProducts', [ProductsController::class, 'getProducts'])->name('products.getProducts');
    Route::post('getProduct', [ProductsController::class, 'getProduct'])->name('products.getProduct');
    Route::post('update', [ProductsController::class, 'update'])->name('products.update');
    Route::post('delete', [ProductsController::class, 'deleteProduct'])->name('products.delete');
});

Route::group(['prefix' => 'orders'], function(){
    Route::get('/orders/list', [OrdersController::class, 'ordersList'])->name('orders.orders');
    Route::post("viewOrder", [OrdersController::class, 'viewOrder'])->name('orders.viewOrder');
    Route::post('manageOrder', [OrdersController::class, 'manageOrder'])->name('orders.manageOrder');
    Route::post('received', [OrdersController::class, 'orderReceived'])->name('orders.received');
});

Route::group(['middleware' => 'noCustomer'], function(){

    // For Raw Materials
    Route::group(['prefix' => 'raw-materials'], function(){
        Route::get('/', [RawMaterialsController::class, 'index'])->name('raw.index');
        Route::post('/getRawMaterials', [RawMaterialsController::class, 'getRawMaterials'])->name('raw.getRawMaterials');
        Route::post('/store', [RawMaterialsController::class, 'store'])->name('raw.store');
        Route::post('/getRawMaterial', [RawMaterialsController::class, 'getRawMaterial'])->name('raw.getRawMaterial');
        Route::post('/update', [RawMaterialsController::class, 'update'])->name('raw.update');
        Route::post('/delete', [RawMaterialsController::class, 'delete'])->name('raw.delete');
        Route::get('/create', [RawMaterialsController::class, 'create'])->name('raw.create');
    });




    // For Suppliers
    Route::group(['prefix' => 'suppliers'], function(){
        Route::get('/', [SuppliersController::class, 'index'])->name('suppliers.index');
        Route::post('getSuppliers', [SuppliersController::class, 'getSuppliers'])->name('suppliers.getSuppliers');
        Route::post('store', [SuppliersController::class, 'store'])->name('suppliers.store');
        Route::post('getSupplier', [SuppliersController::class, 'getSupplier'])->name('suppliers.getSupplier');
        Route::post('update', [SuppliersController::class, 'update'])->name('suppliers.update');
    });


    // For Inventory
    Route::group(['prefix' => 'inventory'], function(){
        Route::get('/', [InventoryController::class, 'index'])->name('inventory.index');
        Route::post('getProducts', [InventoryController::class, 'getProducts'])->name('inventory.getProducts');
    });

    // For Produce
    Route::group(['prefix' => 'activities/produce'], function(){
        Route::get('/', [ProduceController::class, 'index'])->name('produce.index');
        Route::post('produce', [ProduceController::class, 'produce'])->name('produce.produce');
    });

    // For Purchase
    Route::group(['prefix' => 'activities/purchase'], function(){
        Route::get('/', [PurchaseController::class, 'index'])->name('purchase.index');
    });


    // For Warehouse
    Route::group(['prefix' => 'warehouse'], function(){
        Route::get('/', [WarehouseController::class, 'index'])->name('warehouse.index');
        Route::post('store', [WarehouseController::class, 'store'])->name('warehouse.store');
        Route::post('update', [WarehouseController::class, 'update'])->name('warehouse.update');
        Route::post('getWarehouses', [WarehouseController::class, 'getWarehouses'])->name('warehouse.getWarehouses');
        Route::post('getWarehouse', [WarehouseController::class, 'getWarehouse'])->name('warehouse.getWarehouse');
        Route::post('deleteWarehouse', [WarehouseController::class, 'deleteWarehouse'])->name('warehouse.deleteWarehouse');
    });

    // For Warehouse Inventory
    Route::group(['prefix' => 'warehouse-inventory'], function(){
        Route::get('/', [WarehouseInventoryController::class, 'index'])->name('warehouse_inventory.index');
        Route::get('manage/{slug}', [WarehouseInventoryController::class, 'manage'])->name('warehouse_inventory.manage');
        Route::get('manage/inventory/{slug}', [WarehouseInventoryController::class, 'inventory'])->name('warehouse_inventory.inventory');
        Route::post('inventory/products/{slug}', [WarehouseInventoryController::class, 'getProducts'])->name('warehouse_inventory.getProducts');
        Route::post('inventory/getProduct', [WarehouseInventoryController::class, 'getProduct'])->name('warehouse_inventory.getProduct');
        Route::post('inventory/manageInventory', [WarehouseInventoryController::class, 'manageInventory'])->name('warehouse_inventory.manageInventory');
        Route::post('inventory/deleteInventory', [WarehouseInventoryController::class, 'deleteInventory'])->name('warehouse_inventory.deleteInventory');
        Route::post('inventory/moveToLogisticWarehouse', [WarehouseInventoryController::class, 'moveToLogisticWarehouse'])->name('warehouse_inventory.moveToLogisticWarehouse');
    });

    // For Orders
    Route::group(['prefix' => 'orders'], function(){
        Route::get('/{slug?}', [OrdersController::class, 'index'])->name('orders.index');
        Route::get('/create/{slug?}', [OrdersController::class, 'createOrder'])->name('orders.create');
        Route::post('/getCustomer', [OrdersController::class, 'getCustomer'])->name('orders.getCustomer');
        Route::post('/getProductsByWarehouse', [OrdersController::class, 'getProductsByWarehouse'])->name('orders.getProductsByWarehouse');
        Route::post('/submitOrder', [OrdersController::class, "submitOrder"])->name('orders.submitOrder');

        Route::get('generate/invoice/{orderID}', [OrdersController::class, 'generateInvoice'])->name('orders.generateInvoice');

    });

    // For Reports
    Route::group(['prefix' => 'reports'], function(){
        Route::get('/', [ReportsController::class, 'index'])->name('reports.index');
    });

    // For Management
    Route::group(['prefix' => 'management'], function(){
        Route::get('user', [ManagementController::class, 'index'])->name('management.index');
        Route::post('store', [ManagementController::class, 'store'])->name('management.store');
        Route::post('getUser', [ManagementController::class, 'getUser'])->name('management.getUser');
        Route::post('update', [ManagementController::class, 'update'])->name('management.update');
        Route::post('deleteUser', [ManagementController::class, 'deleteUser'])->name('management.deleteUser');
        Route::get('customers', [ManagementController::class, 'customerIndex'])->name('management.customers');
    });

    // For Logs
    Route::group(['prefix' => 'user-log'], function(){
        Route::get('/', [UserLogController::class, 'index'])->name('user_log.index');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
