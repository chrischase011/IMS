@extends('layouts.app')

@section('content')

<style>
    body {
        background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("https://images.pexels.com/photos/4483610/pexels-photo-4483610.jpeg?cs=srgb&dl=pexels-tiger-lily-4483610.jpg&fm=jpg");
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
            <a href="{{ route('warehouse.index') }}" class="btn btn-lg btn-light border btn-inventory d-flex align-items-center justify-content-center"><i class="fa fa-warehouse me-2"></i>Manage Warehouse</a>
        </div>
        <div class="col-6">
            <a href="{{ route('reports.index') }}" class="btn btn-lg btn-light border btn-inventory d-flex align-items-center justify-content-center"><i class="fa fa-chart-line me-2"></i>Reports</a>
        </div>
    </div>

</div>

@endsection
