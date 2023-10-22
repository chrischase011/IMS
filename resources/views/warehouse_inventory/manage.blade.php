@extends('layouts.app')

@section('content')
    <style>
        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("https://images.pexels.com/photos/4483610/pexels-photo-4483610.jpeg?cs=srgb&dl=pexels-tiger-lily-4483610.jpg&fm=jpg");
            background-size: cover;
            background-position: center;
            font-family: 'Montserrat', sans-serif;
        }

        .th-sp {
            vertical-align: middle;
        }

        .in {
            background-color: #72f788 !important;
        }

        .out {
            background-color: #dc6464 !important;
        }

        .bal {
            background-color: #c2c55c !important;
        }

        .rawbal {
            background-color: #e7bf6a !important;
        }
    </style>

    <div class="container bg-white py-3 ">
        <h3>Manage <strong>{{ $warehouse->name }}</strong></h3>

        @include('inc.alert')

        <hr>

        <h4 class="mb-3">Inventory Monitoring</h4>

        <div class="row my-3">
            <div class="col-12 d-flex justify-content-end">

                {{-- @if ($warehouse->type == 1)
                    <a href="{{ route('raw.index') }}" class="btn btn-warning">Purchase
                        Raw Materials</a>
                @endif
                @if ($warehouse->type == 2)
                    <a href="{{ route('orders.index', ['slug' => $slug]) }}" class="btn btn-warning">Manage
                        Orders</a>
                @endif --}}

                <a href="{{ route('warehouse_inventory.inventory', ['slug' => $slug]) }}" class="btn btn-primary mx-3">View
                    Warehouse Inventory</a>
            </div>
        </div>
        <div class="row justify-content-center my-3 border-end">

            <div class="col-6 table-responsive py-3">
                <table class="table table-stocks table-light table-striped table-bordered" id="table">
                    <thead>
                        <tr>
                            <th colspan="{{ $warehouse->type == 2 ? '5' : '4' }}" class="text-center in">Stock In</th>
                        </tr>

                        <tr>
                            <th>Date</th>
                            <th>Item</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            @if ($warehouse->type == 2)
                                <th>Operation</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stocks['stockIn'] as $stockIn)
                            <tr>
                                <td>{{ date('m/d/Y', strtotime($stockIn->transaction_date)) }}</td>
                                <td>
                                    @if ($stockIn->product)
                                        {{ $stockIn->product->name }}
                                    @elseif($stockIn->rawMaterial)
                                        {{ $stockIn->rawMaterial->name }}
                                    @else
                                        Deleted Item
                                    @endif


                                </td>
                                <td>
                                    @if ($stockIn->product)
                                        Product
                                    @elseif($stockIn->rawMaterial)
                                        Raw Material
                                    @else
                                        Undefined Type
                                    @endif
                                </td>
                                <td>{{ abs($stockIn->quantity_in) }}</td>
                                @if ($warehouse->type == 2)
                                    <td>{{ $stockIn->transaction_operation }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>


                </table>
            </div>

            <div class="col-6 table-responsive py-3 border-start">
                <table class="table table-stocks table-light table-striped table-bordered" id="table">
                    <thead>
                        <tr>
                            <th colspan="{{ $warehouse->type == 2 ? '5' : '4' }}" class="text-center out">Stock Out</th>
                        </tr>

                        <tr>
                            <th>Date</th>
                            <th>Item</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            @if ($warehouse->type == 2)
                                <th>Operation</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($stocks['stockOut'] as $stockOut)
                            <tr>
                                <td>{{ date('m/d/Y', strtotime($stockIn->transaction_date)) }}</td>
                                <td>
                                    @if ($stockOut->product)
                                        {{ $stockOut->product->name }}
                                    @elseif($stockOut->rawMaterial)
                                        {{ $stockOut->rawMaterial->name }}
                                    @else
                                        Deleted Item
                                    @endif
                                </td>
                                <td>
                                    @if ($stockOut->product)
                                        Product
                                    @elseif($stockOut->rawMaterial)
                                        Raw Materials
                                    @else
                                        Undefined Type
                                    @endif
                                </td>
                                <td>{{ abs($stockOut->quantity_out) }}</td>
                                @if ($warehouse->type == 2)
                                    <td>{{ $stockOut->transaction_operation }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>


                </table>
            </div>
        </div>

        <hr>
        <div class="row my-3 justify-content-center">
            <div class="col-10 table-responsive">
                <table class="table table-light table-striped table-bordered" id="table">
                    <thead>
                        <tr>
                            <th colspan="4" class="text-center bal">Product Stock Balance</th>
                        </tr>

                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Safety Stock</th>
                            <th>Stock Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->product->name }}</td>
                                <td>{{ $product->current_quantity }}</td>
                                <td>{{ $product->reorder_level }}</td>
                                <td>
                                    @if ($product->current_quantity == 0)
                                        <span class="badge badge-lg bg-danger">No Stocks</span>
                                    @elseif($product->current_quantity < $product->reorder_level)
                                        <span class="badge badge-lg bg-warning">Insufficient Stocks</span>
                                    @else
                                        <span class="badge badge-lg bg-success">Sufficient Stocks</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>


                </table>
            </div>
        </div>

        @if ($warehouse->type == 1)
            <div class="row my-3 justify-content-center">
                <div class="col-10 table-responsive">
                    <table class="table table-light table-striped table-bordered" id="table">
                        <thead>
                            <tr>
                                <th colspan="4" class="text-center rawbal">Raw Materials Stock Balance</th>
                            </tr>

                            <tr>
                                <th>Raw Materials Name</th>
                                <th>Quantity</th>
                                <th>Safety Stock</th>
                                <th>Stock Status</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($rawMaterials as $rawMaterial)
                                <tr>
                                    <td>{{ $rawMaterial->name }}</td>
                                    <td>{{ $rawMaterial->quantity }}</td>
                                    <td>{{ $rawMaterial->reorder_level }}</td>
                                    <td>
                                        @if ($rawMaterial->quantity == 0)
                                            <span class="badge badge-lg bg-danger">No Stocks</span>
                                        @elseif($rawMaterial->quantity < $rawMaterial->reorder_level)
                                            <span class="badge badge-lg bg-warning">Insufficient Stocks</span>
                                        @else
                                            <span class="badge badge-lg bg-success">Sufficient Stocks</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>


                    </table>
                </div>
            </div>
        @endif

    </div>

    <script>
        $(() => {
            table = $(".table").DataTable({
                responsive: true,
                width: '100%',
                language: {
                    loadingRecords: "Fetching Data... Please Wait!"
                },
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });

            var table_stocks = $(".table-stocks").DataTable({
                responsive: true,
                width: '100%',
                order: [[0, 'desc']],
                language: {
                    loadingRecords: "Fetching Data... Please Wait!"
                },
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
@endsection
