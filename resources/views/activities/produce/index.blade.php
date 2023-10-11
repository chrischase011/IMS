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


    <div class="container bg-white pt-3 pb-5 ">
        <h3>Produce a Product</h3>

        @include('inc.alert')

        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a href="{{ route('inventory.index') }}" class="btn btn-secondary me-3" title="Go to Inventory"><i
                        class="fa fa-box-open"></i></a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-10 table-responsive">
                <form action="{{ route('produce.produce') }}" method="post">
                    @csrf

                    <div class="row">
                        <label class="col-12">Warehouse</label>
                        <div class="col-12">
                            <select class="form-select" name="warehouse_id" id="list-warehouse" required>
                                <option value="">-- Select Production Warehouse --</option>
                                @foreach ($warehouses as $warehouse)
                                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row my-3">
                        <label class="col-12">Product to Produce</label>
                        <div class="col-12">
                            <select class="form-select" name="id" id="list-products">
                                <option value="">-- Select Product to Produce --</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-12">
                            <div id="req">

                            </div>
                        </div>
                    </div>

                    <div class="row my-3 d-none qp">
                        <label class="col-12">Quantity of Product to Produce</label>
                        <div class="col-12">
                            <input type="number" name="quantity" class="form-control" id="quantity" required>
                        </div>
                    </div>

                    <div class="row my-3 d-none qp">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Produce</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

    <script>
        $(() => {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });


            $("#list-products").on('change', () => {
                var id = $("#list-products").val();

                $("#req").html("");
                $(".qp").addClass("d-none");

                if (id == null) {
                    return;
                }

                $.ajax({
                    url: "{{ route('products.getProduct') }}",
                    type: 'post',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: (data) => {
                        console.log(data);

                        var product = data.product.product_requirements;
                        var appendToDiv = `<p class="h5 pb-3">Product Requirements:</p>`;

                        $.each(product, (i, e) => {
                            appendToDiv += `
                            <p class="h6">${e.raw_material.name}: ${e.quantity}</p>
                        `;



                        });

                        $("#req").append(appendToDiv);

                        $(".qp").removeClass("d-none");

                    }
                });
            });
        });
    </script>
@endsection
