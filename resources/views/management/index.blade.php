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
                                    <button type="button" class="btn btn-info" onclick="viewEdit($admin->id)">Edit</button>
                                    <button type="button" class="btn btn-danger"
                                        onclick="deleteUser($admin->id)">Delete</button>
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
                                    <button type="button" class="btn btn-info"
                                        onclick="viewEdit($employee->id)">Edit</button>
                                    <button type="button" class="btn btn-danger"
                                        onclick="deleteUser($employee->id)">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        {{-- Customers --}}
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
                                        onclick="viewEdit($customere->id)">Edit</button>
                                    <button type="button" class="btn btn-danger"
                                        onclick="deleteUser($customer->id)">Delete</button>
                                </td>
                            </tr>
                        @endforeach
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

            table = $(".table").DataTable({
                responsive: true,
                width: '100%',
                language: {
                    loadingRecords: "Fetching Data... Please Wait!"
                },
            });

            $("#btnAddUser").on('click', ()=>{
                $("#mdlAdd").modal('show');
            });


            $("#form_add").on('submit', function(e){
                var password = $("#frmPassword").val();
                var confirmPass = $("#frmPasswordConfirm").val();

                if(confirmPass !== password)
                {
                    e.preventDefault();

                    Swal.fire({
                        title: "Password did not match.",
                        icon: 'error'
                    });
                }

            });

        });
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
                                <input type="password" name="password_confirmation" id="frmPasswordConfirm" class="form-control">
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
                                    <option value="2">Employee</option>
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
@endsection
