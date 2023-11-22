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
        <h3>Warehouse</h3>

        @include('inc.alert')

        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <button type="button" id="btnAdd" class="btn btn-primary me-3" title="Add Warehouse"><i
                        class="fa fa-plus"></i></button>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-10 table-responsive">
                <table class="table table-light table-bordered table-striped" id="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Date Created/Updated</th>
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
                    url: "{{ route('warehouse.getWarehouses') }}",
                    type: 'post',
                },
                columns: [{
                        data: "name"
                    },
                    {
                        data: 'type',
                        render: (e) => {
                            switch (e) {
                                case 1:
                                    return "Production";
                                    break

                                case 2:
                                    return "Logistics";
                                    break
                            }
                        }
                    },
                    {
                        data: "status",
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
                            const formattedDate = moment(e).format('MMM. D, YYYY');

                            return formattedDate;
                        }
                    },
                    {
                        data: {
                            'id': 'id',
                            'slug': 'slug',
                            'status': 'status'
                        },
                        render: (e) => {
                            var status = "";

                            if (e.status == '2')
                                status = 'disabled'

                            return `
                            <a href="warehouse-inventory/manage/${e.slug}" class='btn btn-success ${status}'>Manage</a>
                            <button type='button' onclick="viewEdit(${e.id})" class='btn btn-info'>Edit</button>
                            <button type='button' onclick="deleteWarehouse(${e.id})" class='btn btn-danger'>Delete</button>`;
                        },
                        orderable: false
                    }
                ]
            });


            $("#btnAdd").on('click', () => {
                $("#mdlAdd").modal('show');
            });
        });


        var viewEdit = (id) => {
            $.ajax({
                url: "{{ route('warehouse.getWarehouse') }}",
                type: 'post',
                data: {
                    id: id
                },
                dataType: 'json',
                success: (data) => {
                    $("#editID").val(id);
                    $("#editName").val(data.name);
                    $("#editType").val(data.type);
                    $("#editStatus").val(data.status);
                    $("#mdlEdit").modal('show');
                }
            });
        }

        var deleteWarehouse = (id) => {
            Swal.fire({
                title: "Delete?",
                text: "Are you sure you want to delete?",
                icon: 'question',
                showCancelButton: true
            }).then((res) => {
                if (res.isConfirmed) {
                    $.ajax({
                        url: "{{ route('warehouse.deleteWarehouse') }}",
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



    <div class="modal fade" id="mdlAdd">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Warehouse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('warehouse.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-12">Warehouse Name</label>
                            <div class="col-12">
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                        </div>
                        <div class="row my-3">
                            <label class="col-12">Warehouse Type</label>
                            <div class="col-12">
                                <select name="type" id="type" class="form-select" required>
                                    <option value="1">Production</option>
                                    <option value="2">Logistics</option>
                                </select>
                            </div>
                        </div>
                        <div class="row my-3">
                            <label class="col-12">Warehouse Status</label>
                            <div class="col-12">
                                <select name="status" id="status" class="form-select" required>
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
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

    <div class="modal fade" id="mdlEdit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Warehouse</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('warehouse.update') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" id="editID">
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-12">Warehouse Name</label>
                            <div class="col-12">
                                <input type="text" name="name" id="editName" class="form-control" required>
                            </div>
                        </div>
                        <div class="row my-3">
                            <label class="col-12">Warehouse Type</label>
                            <div class="col-12">
                                <select name="type" id="editType" class="form-select" required>
                                    <option value="1">Production</option>
                                    <option value="2">Logistics</option>
                                </select>
                            </div>
                        </div>
                        <div class="row my-3">
                            <label class="col-12">Warehouse Status</label>
                            <div class="col-12">
                                <select name="status" id="editStatus" class="form-select" required>
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
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
