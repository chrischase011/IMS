@extends('layouts.app')

@section('content')
    <script src="{{ URL::asset('assets/js/city.js') }}"></script>
    <style>
        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("https://images.pexels.com/photos/4483610/pexels-photo-4483610.jpeg?cs=srgb&dl=pexels-tiger-lily-4483610.jpg&fm=jpg");
            background-size: cover;
            background-position: center;
            font-family: 'Montserrat', sans-serif;
        }
    </style>

    <div class="container bg-white py-3 ">
        <h3>Suppliers</h3>

        @include('inc.alert')

        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <button type="button" id="btnAdd" class="btn btn-primary me-3" title="Add Supplier"><i
                        class="fa fa-plus"></i></button>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 table-responsive">
                <table class="table table-light table-bordered table-striped" id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Contact Name</th>
                            <th>Contact Email</th>
                            <th>Contact Phone</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Province</th>
                            <th>Postal Code</th>
                            <th>Country</th>
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
        var $list = new City();
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
                    url: "{{ route('suppliers.getSuppliers') }}",
                    type: 'post',
                },
                columns: [
                    {
                        data:'id'
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: 'contact_name'
                    },
                    {
                        data: 'contact_email'
                    },
                    {
                        data: 'contact_phone'
                    },
                    {
                        data: 'address'
                    },
                    {
                        data: 'city'
                    },
                    {
                        data: 'province'
                    },
                    {
                        data: 'postal_code'
                    },
                    {
                        data: 'country'
                    },
                    {
                        data: 'id',
                        render: (e) => {
                            return `<button type='button' onclick="viewEdit(${e})" class='btn btn-info'>Edit</button>
                            <button type='button' onclick="deleteSupplier(${e})" class='btn btn-danger'>Delete</button>`;
                        },
                        orderable: false
                    }
                ]

            });

            $("#btnAdd").on('click', ()=>{
                $("#mdlAdd").modal('show');
            });
        });

        var viewEdit = (id) => {
            $.ajax({
                url: "{{ route('suppliers.getSupplier') }}",
                type: 'post',
                data: {
                    id: id
                },
                dataType: 'json',
                success: (data) => {

                    $("#mdlEdit").modal('show');
                    $("#editID").val(data.id);
                    $("#editName").val(data.name);
                    $("#editContactName").val(data.contact_name);
                    $("#editContactEmail").val(data.contact_email);
                    $("#editContactPhone").val(data.contact_phone);
                    $("#editAddress").text(data.address);
                    $("#editProvince").val(data.province);

                    $list.showCities(data.province, "#editCity");
                    $("#editCity").val(data.city);
                    $("#editPostalCode").val(data.postal_code);
                    $("#editCountry").val(data.country);

                }
            });

        }

        var deleteSupplier = (id) => {
            Swal.fire({
                title: "Delete?",
                text: "Are you sure you want to delete this supplier?",
                icon: 'question',
                showCancelButton: true
            }).then((res)=>{
                if(res.isConfirmed)
                {
                    $.ajax({
                        url: "{{ route('suppliers.delete') }}",
                        type: 'post',
                        data: {id:id},
                        dataType: 'html',
                        success: (data) =>{
                            table.ajax.reload(false, null);
                        }
                    });
                }
            });
        }


        $(() => {

            $list.showProvinces("#province");
            $list.showProvinces("#editProvince");

            $("#province").on('change', function(){
                var prov = $(this).val();
                $list.showCities(prov,'#city');
            });

            $("#editProvince").on('change', function(){
                var prov = $(this).val();
                $list.showCities(prov,'#editCity');
            });

        });
    </script>



    <div class="modal fade" id="mdlAdd">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('suppliers.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-12">Name</label>
                            <div class="col-12">
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Contact Name</label>
                            <div class="col-12">
                                <input type="text" name="contact_name" id="contact_name" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Contact Email</label>
                            <div class="col-12">
                                <input type="email" name="contact_email" id="contact_email" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Contact Phone</label>
                            <div class="col-12">
                                <input type="text" name="contact_phone" id="contact_phone" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Country</label>
                            <div class="col-12">
                                <select id="country" name="country" class="form-control" required>
                                    <option value="Philippines">Philippines</option>
                                </select>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Address</label>
                            <div class="col-12">
                                <textarea name="address" id="address" rows="3" style="resize: none" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Province</label>
                            <div class="col-12">
                                {{-- <input type="text" name="province" id="province" class="form-control" required> --}}
                                <select name="province" id="province" class="form-select" required></select>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">City</label>
                            <div class="col-12">
                                {{-- <input type="text" name="city" id="city" class="form-control" required> --}}
                                <select name="city" id="city" class="form-select" required></select>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Postal Code</label>
                            <div class="col-12">
                                <input type="text" name="postal_code" id="postal_code" class="form-control" required>
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
                    <h5 class="modal-title">Edit Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('suppliers.update') }}" method="post">
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
                            <label class="col-12">Contact Name</label>
                            <div class="col-12">
                                <input type="text" name="contact_name" id="editContactName" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Contact Email</label>
                            <div class="col-12">
                                <input type="email" name="contact_email" id="editContactEmail" class="form-control" required>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Contact Phone</label>
                            <div class="col-12">
                                <input type="text" name="contact_phone" id="editContactPhone" class="form-control" required>
                            </div>
                        </div>


                        <div class="row my-3">
                            <label class="col-12">Country</label>
                            <div class="col-12">
                                <select id="editCountry" name="country" class="form-control" required>
                                    <option value="Philippines">Philippines</option>
                                </select>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Address</label>
                            <div class="col-12">
                                <textarea name="address" id="editAddress" rows="3" style="resize: none" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">Province</label>
                            <div class="col-12">
                                {{-- <input type="text" name="province" id="editProvince" class="form-control" required> --}}
                                <select name="province" id="editProvince" class="form-select" required></select>
                            </div>
                        </div>

                        <div class="row my-3">
                            <label class="col-12">City</label>
                            <div class="col-12">
                                {{-- <input type="text" name="city" id="editCity" class="form-control" required> --}}
                                <select name="city" id="editCity" class="form-select" required></select>
                            </div>
                        </div>


                        <div class="row my-3">
                            <label class="col-12">Postal Code</label>
                            <div class="col-12">
                                <input type="text" name="postal_code" id="editPostalCode" class="form-control" required>
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
