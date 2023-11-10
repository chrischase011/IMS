@extends('layouts.app')

@section('content')
    <div class="container bg-white py-3 ">
        <h3>Users Management</h3>
        @include('inc.alert')

        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <button type="button" id="btnAddUser" class="btn btn-primary me-3" title="Add Users"><i
                        class="fa fa-user-plus"></i></button>
            </div>
        </div>

        {{-- Admin --}}
        <div class="row justify-content-center my-3">
            <div class="col-10 table-responsive">
                <h4>Admins</h4>
                <table class="table table-light table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $admin)
                            <tr>
                                <td>{{ $admin->firstname . ' ' . $admin->lastname }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->phone }}</td>
                                <td>{{ date('F d, Y', strtotime($admin->created_at)) }}</td>
                                <td>
                                    @if (Auth::id() != $admin->id)
                                        @if ($admin->status == 1)
                                            <button type="button" class="btn btn-warning"
                                                onclick="disableAccount({{ $admin->id }})">Disable</button>
                                        @else
                                            <button type="button" class="btn btn-success"
                                                onclick="enableAccount({{ $admin->id }})">Enable</button>
                                        @endif
                                    @endif
                                    <button type="button" class="btn btn-info"
                                        onclick="viewEdit({{ $admin->id }})">Edit</button>

                                    @if (Auth::id() == $admin->id)
                                        <button type="button" class="btn btn-danger" disabled>Delete</button>
                                    @else
                                        <button type="button" class="btn btn-danger"
                                            onclick="deleteUser({{ $admin->id }})">Delete</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        {{-- Employees --}}
        <div class="row justify-content-center my-3">
            <div class="col-10 table-responsive">
                <h4>Employees</h4>
                <table class="table table-light table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $employee->firstname . ' ' . $employee->lastname }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->phone }}</td>
                                <td>{{ date('F d, Y', strtotime($employee->created_at)) }}</td>
                                <td>
                                    @if (Auth::id() != $employee->id)
                                        @if ($employee->status == 1)
                                            <button type="button" class="btn btn-warning"
                                                onclick="disableAccount({{ $employee->id }})">Disable</button>
                                        @else
                                            <button type="button" class="btn btn-success"
                                                onclick="enableAccount({{ $employee->id }})">Enable</button>
                                        @endif
                                    @endif

                                    <button type="button" class="btn btn-info"
                                        onclick="viewEdit({{ $employee->id }})">Edit</button>

                                    @if (Auth::id() == $employee->id)
                                        <button type="button" class="btn btn-danger" disabled>Delete</button>
                                    @else
                                        <button type="button" class="btn btn-danger"
                                            onclick="deleteUser({{ $employee->id }})">Delete</button>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        {{-- Customers
        <div class="row justify-content-center my-3">
            <div class="col-10 table-responsive">
                <h4>Customers</h4>
                <table class="table table-light table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Date Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer->firstname . ' ' . $customer->lastname }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone }}</td>
                                <td>{{ date('F d, Y', strtotime($customer->created_at)) }}</td>
                                <td>
                                    <button type="button" class="btn btn-info"
                                        onclick="viewEdit({{ $customer->id }})">Edit</button>
                                    <button type="button" class="btn btn-danger"
                                        onclick="deleteUser({{ $customer->id }})">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> --}}
    </div>


    <script>
        var table;

        $(() => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            });

            table = $(".table").DataTable({
                responsive: true,
                width: '100%',
                language: {
                    loadingRecords: "Fetching Data... Please Wait!"
                },
            });

            $("#btnAddUser").on('click', () => {
                $("#mdlAdd").modal('show');
            });


            $("#form_add").on('submit', function(e) {
                var password = $("#frmPassword").val();
                var confirmPass = $("#frmPasswordConfirm").val();

                if (confirmPass !== password) {
                    e.preventDefault();

                    Swal.fire({
                        title: "Password did not match.",
                        icon: 'error'
                    });
                }

            });

        });

        var viewEdit = (id) => {
            $.ajax({
                url: "{{ route('management.getUser') }}",
                type: 'post',
                data: {
                    id: id
                },
                dataType: 'json',
                success: (data) => {
                    $("#editID").val(data.id);
                    $("#editFirstName").val(data.firstname);
                    $("#editLastName").val(data.lastname);
                    $("#editEmail").val(data.email);
                    $("#editPhone").val(data.phone);
                    $("#editRole").val(data.roles);

                    $("#mdlEdit").modal('show');
                }
            });
        }

        var deleteUser = (id) => {

            Swal.fire({
                title: "Delete?",
                text: "Are you sure you want to delete this user?",
                icon: 'question',
                showCancelButton: true
            }).then((res) => {
                if (res.isConfirmed) {
                    $.ajax({
                        url: "{{ route('management.deleteUser') }}",
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: (data) => {
                            window.location.reload();
                        }
                    });
                }
            });
        }


        var disableAccount = (id) => {

            Swal.fire({
                title: "Disable?",
                text: "Are you sure you want to disable the account of this user?",
                icon: 'question',
                showCancelButton: true
            }).then((res) => {
                if (res.isConfirmed) {
                    $.ajax({
                        url: "{{ route('management.disableAccount') }}",
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: (data) => {
                            window.location.reload();
                        }
                    });
                }
            });

        }

        var enableAccount = (id) => {

            Swal.fire({
                title: "Enable?",
                text: "Are you sure you want to enable the account of this user?",
                icon: 'question',
                showCancelButton: true
            }).then((res) => {
                if (res.isConfirmed) {
                    $.ajax({
                        url: "{{ route('management.enableAccount') }}",
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'json',
                        success: (data) => {
                            window.location.reload();
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
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_add" action="{{ route('management.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-12">First Name</label>
                            <div class="col-12">
                                <input type="text" name="firstname" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Last Name</label>
                            <div class="col-12">
                                <input type="text" name="lastname" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Email</label>
                            <div class="col-12">
                                <input type="email" name="email" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Password</label>
                            <div class="col-12">
                                <input type="password" name="password" id="frmPassword" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Confirm Password</label>
                            <div class="col-12">
                                <input type="password" name="password_confirmation" id="frmPasswordConfirm"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Phone</label>
                            <div class="col-12">
                                <input type="text" name="phone" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Role</label>
                            <div class="col-12">
                                <select name="role" class="form-select" required>
                                    <option value="1">Admin</option>
                                    <option value="4">Sales Employee</option>
                                    <option value="5">Purchase Employee</option>
                                    <option value="6">Inventory Employee</option>
                                    <option value="7">Warehouse Employee</option>
                                    <option value="3">Customer</option>
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
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form_add" action="{{ route('management.update') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" id="editID">
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-12">First Name</label>
                            <div class="col-12">
                                <input type="text" name="firstname" id="editFirstName" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Last Name</label>
                            <div class="col-12">
                                <input type="text" name="lastname" id="editLastName" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Email</label>
                            <div class="col-12">
                                <input type="email" id="editEmail" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Password</label>
                            <div class="col-12">
                                <input type="password" name="password" id="editPassword" class="form-control">
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Phone</label>
                            <div class="col-12">
                                <input type="text" name="phone" id="editPhone" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Role</label>
                            <div class="col-12">
                                <select name="role" id="editRole" class="form-select" required>
                                    <option value="1">Admin</option>
                                    <option value="4">Sales Employee</option>
                                    <option value="5">Purchase Employee</option>
                                    <option value="6">Inventory Employee</option>
                                    <option value="7">Warehouse Employee</option>
                                    <option value="3">Customer</option>
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
