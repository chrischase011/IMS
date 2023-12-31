@extends('layouts.app')

@section('content')
    <style>
        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("https://png.pngtree.com/thumb_back/fh260/background/20231005/pngtree-d-illustration-of-a-warehouse-or-storage-facility-with-shelves-and-image_13559015.png");
            background-size: cover;
            background-position: center;
            font-family: 'Montserrat', sans-serif;
        }
    </style>

    <div class="container bg-white py-3 ">
        <h3>Warehouse Inventory - Dashboard</h3>

        @include('inc.alert')

        <div class="row justify-content-center">
            <div class="col-6">
                <a href="{{ route('warehouse.index') }}"
                    class="btn btn-lg btn-light border btn-inventory d-flex align-items-center justify-content-center"><i
                        class="fa fa-warehouse me-2"></i>Manage Warehouse</a>
            </div>
            <div class="col-6 d-none">
                <a href="{{ route('reports.index') }}"
                    class="btn btn-lg btn-light border btn-inventory d-flex align-items-center justify-content-center"><i
                        class="fa fa-chart-line me-2"></i>Reports</a>
            </div>
        </div>

    </div>
@endsection
