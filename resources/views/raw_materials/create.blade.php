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
        <h3>Purchase Raw Materials</h3>
        @include('inc.alert')

        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a href="{{ route('raw.index') }}" id="btnAdd" class="btn btn-secondary me-3" title="Add Raw Material"><i
                        class="fa fa-arrow-left"></i></a>

            </div>
        </div>

        <div class="row my-3 justify-content-center">
            <div class="col-10">
                <form action="{{ route('raw.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <label class="col-12">Name</label>
                        <div class="col-12">
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                    </div>

                    <div class="row my-3">
                        <label class="col-12">Quantity</label>
                        <div class="col-12">
                            <input type="number" name="quantity" id="quantity" min="1" class="form-control"
                                required>
                        </div>
                    </div>

                    <div class="row my-3">
                        <label class="col-12">Price</label>
                        <div class="col-12">
                            <input type="number" name="price" id="price" min="1" class="form-control"
                                required>
                        </div>
                    </div>

                    <div class="row my-3">
                        <label class="col-12">Description</label>
                        <div class="col-12">
                            <textarea name="description" id="description" rows="5" style="resize: none" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="row my-3">
                        <label class="col-12">Reorder Level</label>
                        <div class="col-12">
                            <input type="number" name="reorder_level" id="reorder_level" class="form-control" required>
                        </div>
                    </div>

                    <div class="row my-3">
                        <label class="col-12">Assign Warehouse</label>
                        <div class="col-12">
                            <select class="form-select" name="warehouse" id="warehouse">
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row my-3">
                        <label class="col-12">Supplier</label>
                        <div class="col-12">
                            <select class="form-select" name="supplier" id="supplier">
                                <option value="">No Supplier</option>
                                @foreach ($suppliers as $_supplier)
                                    <option value="{{ $_supplier->id }}">{{ $_supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row my-3">
                        <label class="col-12">Availability</label>
                        <div class="col-12">
                            <select class="form-control" name="availability" id="availability" required>
                                <option value="1">Yes</option>
                                <option value="2">No</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success float-end">Add</button>
                </form>
            </div>
        </div>
    </div>
@endsection
