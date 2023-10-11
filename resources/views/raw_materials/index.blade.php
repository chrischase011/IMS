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
        <h3>Raw Materials</h3>

        @include('inc.alert')

        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <button type="button" id="btnAddRaw" class="btn btn-primary me-3" title="Add Raw Material"><i
                        class="fa fa-plus"></i></button>
            </div>
        </div>
        <div class="row my-3 justify-content-center">
            <div class="col-12 table-responsive">
                <table class="table table-light table-bordered table-striped" id="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Warehouse</th>
                            <th>Supplier</th>
                            <th>Availability</th>
                            <th>Date Received</th>
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
                    url: "{{ route('raw.getRawMaterials') }}",
                    type: 'post',
                },
                columns: [{
                        data: 'name'
                    },
                    {
                        data: 'quantity'
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
                        data: 'description'
                    },
                    {
                        data: 'warehouse',
                        render: (e) => {
                            if(e == null || typeof e == undefined)
                                return 'No Warehouse';

                            return e.name;
                        }
                    },
                    {
                        data: 'supplier',
                        render: (e) => {
                            if (e !== null) {
                                return e.name;
                            }
                            return "No Supplier";
                        }
                    },
                    {
                        data: 'availability',
                        render: (e) => {
                            switch (e) {
                                case '1':
                                    return `<span class='badge bg-success'>Active</span>`;
                                    break;

                                case '2':
                                    return `<span class='badge bg-danger'>Inactive</span>`;
                                    break;
                            }
                        }
                    },
                    {
                        data: 'updated_at',
                        render: (e) => {
                            const formattedDate = moment(e).format('MMM. D, YYYY | hh:mm A');

                            return formattedDate;
                        }
                    },
                    {
                        data: 'id',
                        render: (e) => {
                            return `<button type='button' onclick="viewEdit(${e})" class='btn btn-info'>Edit</button> 
                            <button type='button' onclick="deleteRaw(${e})" class='btn btn-danger mx-1'>Delete</button>`;
                        },
                        orderable: false
                    }
                ],
            });


            setInterval(function() {
                table.ajax.reload(null, false);
            }, 3000);


            $("#btnAddRaw").on('click', () => {
                $("#mdlRaw").modal('show');
            });

            // 
        });


        var viewEdit = (id) => {
            $.ajax({
                url: "{{ route('raw.getRawMaterial') }}",
                type: 'post',
                data: {
                    id: id
                },
                dataType: 'json',
                success: (data) => {
                    $("#editID").val(data.id);
                    $("#editName").val(data.name);
                    $("#editQuantity").val(data.quantity);
                    $("#editPrice").val(data.price);
                    $("#editDescription").text(data.description);
                    $("#editReorderLevel").val(data.reorder_level);
                    $("#editWarehouse").val(data.warehouse_id);
                    $("#editSupplier").val(data.supplier_id);
                    $("#editAvailability").val(data.availability);

                    $("#mdlEditRaw").modal('show');
                }
            });

        }

        var deleteRaw = (id) => {
            Swal.fire({
                title: "Delete?",
                text: "Are you sure you want to delete?",
                icon: 'question',
                showCancelButton: true
            }).then((res) => {
                if (res.isConfirmed) {
                    $.ajax({
                        url: "{{ route('raw.delete') }}",
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
    </script>


    <div class="modal fade" id="mdlRaw">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Purchase Raw Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('raw.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-12">Name</label>
                            <div class="col-12">
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Quantity</label>
                            <div class="col-12">
                                <input type="number" name="quantity" id="quantity" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Price</label>
                            <div class="col-12">
                                <input type="number" name="price" id="price" class="form-control" required>
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
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success float-end">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="mdlEditRaw">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update Purchased Raw Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('raw.update') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" id="editID">
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-12">Name</label>
                            <div class="col-12">
                                <input type="text" name="name" id="editName" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Quantity</label>
                            <div class="col-12">
                                <input type="number" name="quantity" id="editQuantity" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Price</label>
                            <div class="col-12">
                                <input type="number" name="price" id="editPrice" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Description</label>
                            <div class="col-12">
                                <textarea name="description" id="editDescription" rows="5" style="resize: none" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Reorder Level</label>
                            <div class="col-12">
                                <input type="number" name="reorder_level" id="editReorderLevel" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Assign Warehouse</label>
                            <div class="col-12">
                                <select class="form-select disabled" disabled>
                                    @foreach ($warehouses as $_warehouse)
                                        <option value="{{ $_warehouse->id }}">{{ $_warehouse->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Supplier</label>
                            <div class="col-12">
                                <select class="form-select" name="supplier" id="editSupplier">
                                    <option value="">No Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Availability</label>
                            <div class="col-12">
                                <select class="form-control" name="availability" id="editAvailability" required>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
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
@endsection
