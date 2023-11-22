@extends('layouts.app')

@section('content')
    <style>
        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("https://png.pngtree.com/thumb_back/fw800/background/20230618/pngtree-fully-stocked-warehouse-rack-3d-rendering-of-cardboard-box-inventory-image_3638745.jpg");
            background-size: 100% 100%;
            background-position: center;
            font-family: 'Montserrat', sans-serif;
        }
    </style>

    <div class="container bg-white py-3 ">
        <h3>Inventory</h3>

        @include('inc.alert')

        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <a href="{{ route('produce.index') }}" id="btnAdd" class="btn btn-primary me-3" title="Produce a Product"><i
                        class="fa fa-hammer"></i></a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-10 table-responsive">
                <table class="table table-light table-bordered table-striped" id="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Warehouse</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        var table;

        $(() => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            table = $("#table").DataTable({
                responsive: true,
                width: '100%',
                language: {
                    loadingRecords: "Fetching Data... Please Wait!"
                },
                ajax: {
                    url: "{{ route('inventory.getProducts') }}",
                    type: 'post',
                },
                columns: [{
                        data: 'product.name'
                    },
                    {
                        data: 'warehouse.name',
                        render: (e) => {
                            if (e === null || typeof e === undefined)
                                return "No warehouse available";

                            return e;
                        }
                    },
                    {
                        data: 'current_quantity'
                    },
                    {
                        data: 'price',
                        render: (e) => {
                            const formatter = new Intl.NumberFormat('en-PH', {
                                style: 'currency',
                                currency: 'PHP', // Currency code for Philippine Peso
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                            return formatter.format(e);
                        }
                    },
                    {
                        data: 'updated_at',
                        render: (e) => {
                            const formattedDate = moment(e).format('MMM. D, YYYY | hh:mmA');

                            return formattedDate;
                        }
                    },
                    {
                        data: 'id',
                        render: (e) => {
                            return '';
                            return `<button type='button' onclick="moveWarehouse(${e})" class='btn btn-info'>Move to Warehouse</button>
                            <button type='button' onclick="deleteRaw(${e})" class='btn btn-danger mx-1'>Delete</button>`;
                        },
                        orderable: false
                    }
                ]
            });
        });
    </script>
@endsection
