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
        <h3>{{ $warehouse->name }} Inventory</h3>

        @include('inc.alert')

        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-end">
                <a href="{{ route('warehouse_inventory.manage', ['slug' => $warehouse->slug]) }}" id="btnAdd"
                    class="btn btn-secondary me-3" title="Produce a Product"><i class="fa fa-arrow-left"></i></a>

                @if ($warehouse->type == 1)
                    <a href="{{ route('produce.index') }}" id="btnAdd" class="btn btn-primary me-3"
                        title="Produce a Product"><i class="fa fa-hammer"></i></a>
                @endif
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 table-responsive">
                <table class="table table-light table-bordered table-striped" id="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Warehouse</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Reorder Level</th>
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
                    url: "{{ route('warehouse_inventory.getProducts', ['slug' => $slug]) }}",
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
                        data: 'reorder_level'
                    },
                    {
                        data: 'updated_at',
                        render: (e) => {
                            const formattedDate = moment(e).format('MMM. D, YYYY | hh:mmA');

                            return formattedDate;
                        }
                    },
                    {
                        data: {
                            'id': 'id',
                            'warehouse.type': 'warehouse.type'
                        },
                        render: (e) => {

                            switch (e.warehouse.type) {
                                case 1:
                                    return `<button type='button' onclick="manageInventory(${e.id})" class='btn btn-info'>Manage</button>
                                    <button type='button' onclick="moveWarehouse(${e.id})" class='btn btn-warning'>Move to Logistic Warehouse</button>
                                    <button type='button' onclick="deleteInventory(${e.id})" class='btn btn-danger mx-1'>Delete</button>`;
                                    break;

                                case 2:
                                    return `<button type='button' onclick="manageInventory(${e.id})" class='btn btn-info'>Manage</button>
                                <button type='button' onclick="deleteInventory(${e.id})" class='btn btn-danger mx-1'>Delete</button>`;
                                    break
                            }


                        },
                        orderable: false
                    }
                ]
            });
        });


        var manageInventory = (id) => {
            $.ajax({
                url: "{{ route('warehouse_inventory.getProduct') }}",
                type: 'post',
                data: {
                    id: id
                },
                dataType: 'json',
                success: (data) => {
                    console.log(data);
                    $("#mID").val(data.id);
                    $("#mReorder").val(data.reorder_level);
                    $("#mPrice").val(data.price);

                    $("#mdlManage").modal('show');
                }
            });
        }


        var deleteInventory = (id) => {
            Swal.fire({
                title: "Delete?",
                text: "Are you sure you want to delete?",
                icon: 'question',
                showCancelButton: true
            }).then((res) => {
                if (res.isConfirmed) {
                    $.ajax({
                        url: "{{ route('warehouse_inventory.deleteInventory') }}",
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'html',
                        success: (data) => {
                            table.ajax.reload(null, false);
                        }
                    });
                }
            });
        }


        var moveWarehouse = (id) => {
            $("#moveID").val(id);
            $("#moveCurrentWarehouse").val("{{ $warehouse->id }}")
            $("#mdlMove").modal('show');
        }
    </script>


    <div class="modal fade" id="mdlManage">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('warehouse_inventory.manageInventory') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" id="mID">
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-12">Set Reorder Level</label>
                            <div class="col-12">
                                <input type="number" name="reorder_level" class="form-control" id="mReorder">
                            </div>
                        </div>
                        <div class="row my-3">
                            <label class="col-12">Set Price</label>
                            <div class="col-12">
                                <input type="number" name="price" class="form-control" id="mPrice">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success float-end">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="mdlMove">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Move to Logistic Warehouse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('warehouse_inventory.moveToLogisticWarehouse') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" id="moveID">
                    <input type="hidden" name="current_warehouse" id="moveCurrentWarehouse">
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-12">Pick Logistic Warehouse</label>
                            <div class="col-12">
                                <select name="warehouse" class="form-select" required>
                                    @foreach ($logistics as $logistic)
                                        <option value="{{ $logistic->id }}">{{ $logistic->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Delivery Option</label>
                            <div class="col-12">
                                <select name="transaction_operation" class="form-select" required>
                                    <option value="Delivery">Delivery</option>
                                    <option value="Pick-up">Pick-up</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success float-end">Move</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection
