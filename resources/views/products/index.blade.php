@extends('layouts.app')

@section('content')
    <style>
        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("https://png.pngtree.com/thumb_back/fh260/background/20220313/pngtree-large-warehouse-product-warehouse-of-a-factory-image_997557.jpg");
            background-size: cover;
            background-position: center;
            font-family: 'Montserrat', sans-serif;
        }
    </style>
    <div class="container bg-white py-3 ">
        <h3>Products</h3>

        @include('inc.alert')

        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <button type="button" id="btnAddProduct" class="btn btn-primary me-3" title="Add Product"><i
                        class="fa fa-plus"></i></button>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-10 table-responsive">
                <table class="table table-light table-bordered table-striped" id="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Availability</th>
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
                    url: "{{ route('products.getProducts') }}",
                    type: 'post',
                },
                columns: [{
                        data: 'name',
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
                        data: 'id',
                        render: (e) => {
                            var role = '{{ Auth::user()->roles }}';

                            if(role != '3')
                            {
                                return `<button type='button' onclick="viewEdit(${e})" class='btn btn-info'>Edit</button>
                                <button type='button' onclick="deleteProduct(${e})" class='btn btn-danger mx-1'>Delete</button>`;
                            }
                            else{
                                return '';
                            }

                        },
                        orderable: false
                    }

                ],

            });



            $("#btnAddProduct").on('click', () => {
                $("#list-raw").html("");
                $("#mdlAdd").modal('show');
            });
        });
    </script>


    <div class="modal fade" id="mdlAdd">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('products.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <label class="col-12">Name</label>
                            <div class="col-12">
                                <input type="text" name="name" id="name" class="form-control" required>
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
                            <label class="col-12">Availability</label>
                            <div class="col-12">
                                <select class="form-select" name="availability" id="availability" required>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="row my-3">
                            <label class="h5">Product Requirements</label>

                            <div class="col-12">
                                <input type="hidden" id="rawIDs" name="raw_materials_id">
                                <div id="list-raw">

                                </div>

                                <select class="form-select my-3" id="select-list-raw">

                                    @foreach ($rawMaterials as $rawMaterials)
                                        <option value="{{ $rawMaterials->id }}">{{ $rawMaterials->name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" id="addRaw" class="btn btn-secondary btn-sm mt-1">Add Raw
                                    Material</button>


                                <script>
                                    $(() => {
                                        $("#addRaw").on('click', () => {
                                            var selectHasNoOptions = $("#select-list-raw option").length === 0;

                                            if (selectHasNoOptions) {
                                                $("#select-list-raw").attr('disabled', true);
                                                $("#addRaw").attr('disabled', true);
                                                return;
                                            }

                                            var selectedValue = $("#select-list-raw").val();
                                            var selectedText = $("#select-list-raw option:selected").text();

                                            var rawIDs = $("#rawIDs").val();
                                            if (rawIDs === "") {
                                                $("#rawIDs").val(selectedValue);
                                            } else {
                                                $("#rawIDs").val(rawIDs + "," + selectedValue);
                                            }

                                            var appendToList = `
                                            <label id="label${selectedValue}">${selectedText} <input type="number" name='quantity${selectedValue}' required> <button type="button" class="btn btn-transparent" onclick="deleteRequirement(${selectedValue}, '${selectedText}')"><i class='fa fa-x'></i></button><br></label>
                                        `;
                                            $("#list-raw").append(appendToList);

                                            $("#select-list-raw option:selected").remove();

                                            var selectHasNoOptions = $("#select-list-raw option").length === 0;
                                            if (selectHasNoOptions) {
                                                $("#select-list-raw").attr('disabled', true);
                                                $("#addRaw").attr('disabled', true);
                                                return;
                                            }
                                        });
                                    });

                                    var deleteRequirement = (val, name) => {

                                        var hiddenInput = $("#rawIDs");
                                        var currentValues = hiddenInput.val().split(',');
                                        var valToRemove = val.toString();

                                        var filteredValues = currentValues.filter(function(value) {
                                            return value !== valToRemove;
                                        });

                                        hiddenInput.val(filteredValues.join(','));


                                        $("#label" + val).remove();

                                        var revertOption = $("<option>", {
                                            value: `${val}`,
                                            text: `${name}`
                                        });

                                        $("#select-list-raw").append(revertOption);

                                        var selectHasNoOptions = $("#select-list-raw option").length !== 0;

                                        if (selectHasNoOptions) {
                                            $("#select-list-raw").attr('disabled', false);
                                            $("#addRaw").attr('disabled', false);
                                            return;
                                        }
                                    }
                                </script>
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
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('products.update') }}" method="post">
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
                            <label class="col-12">Availability</label>
                            <div class="col-12">
                                <select class="form-select" name="availability" id="editAvailability" required>
                                    <option value="1">Yes</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="row my-3">
                            <label class="h5">Product Requirements</label>

                            <div class="col-12">
                                <input type="hidden" id="editRawIDs" name="raw_materials_id">
                                <input type="hidden" id="editProductReqIDs" name="product_requirements_id">
                                <div id="edit-list-raw">

                                </div>

                                <select class="form-select my-3" id="edit-select-list-raw">

                                    {{-- @foreach ($rawMaterials as $rawMaterials)
                                        <option value="{{ $rawMaterials->id }}">{{ $rawMaterials->name }}</option>
                                    @endforeach --}}
                                </select>
                                <button type="button" id="editAddRaw" class="btn btn-secondary btn-sm mt-1">Add Raw
                                    Material</button>


                                <script>
                                    $(() => {
                                        $("#editAddRaw").on('click', () => {
                                            var selectHasNoOptions = $("#edit-select-list-raw option").length === 0;

                                            if (selectHasNoOptions) {
                                                $("#edit-select-list-raw").attr('disabled', true);
                                                $("#editAddRaw").attr('disabled', true);
                                                return;
                                            }

                                            var selectedValue = $("#edit-select-list-raw").val();
                                            var selectedText = $("#edit-select-list-raw option:selected").text();

                                            var rawIDs = $("#editRawIDs").val();
                                            if (rawIDs === "") {
                                                $("#editRawIDs").val(selectedValue);
                                            } else {
                                                $("#editRawIDs").val(rawIDs + "," + selectedValue);
                                            }

                                            var appendToList = `
                                            <label id="editLabel${selectedValue}">${selectedText} <input type="number" name='editQuantity${selectedValue}' min="1" required> <button type="button" class="btn btn-transparent" onclick="editDeleteRequirement(${selectedValue}, '${selectedText}')"><i class='fa fa-x'></i></button><br></label>
                                        `;
                                            $("#edit-list-raw").append(appendToList);

                                            $("#edit-select-list-raw option:selected").remove();

                                            var selectHasNoOptions = $("#edit-select-list-raw option").length === 0;
                                            if (selectHasNoOptions) {
                                                $("#edit-select-list-raw").attr('disabled', true);
                                                $("#editAddRaw").attr('disabled', true);
                                                return;
                                            }
                                        });
                                    });

                                    var editDeleteRequirement = (val, name) => {

                                        var hiddenInput = $("#editRawIDs");
                                        var currentValues = hiddenInput.val().split(',');
                                        var valToRemove = val.toString();

                                        var filteredValues = currentValues.filter(function(value) {
                                            return value !== valToRemove;
                                        });

                                        hiddenInput.val(filteredValues.join(','));


                                        $("#editLabel" + val).remove();

                                        var revertOption = $("<option>", {
                                            value: `${val}`,
                                            text: `${name}`
                                        });

                                        $("#edit-select-list-raw").append(revertOption);

                                        var selectHasNoOptions = $("#edit-select-list-raw option").length !== 0;

                                        if (selectHasNoOptions) {
                                            $("#edit-select-list-raw").attr('disabled', false);
                                            $("#editAddRaw").attr('disabled', false);
                                            return;
                                        }
                                    }
                                </script>
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


    <script>
        var viewEdit = (id) => {
            $("#editRawIDs").val("");
            $("#editID").val(id);
            $.ajax({
                url: "{{ route('products.getProduct') }}",
                type: 'post',
                data: {
                    id: id
                },
                dataType: 'json',
                success: (data) => {
                    console.log(data);
                    var product = data.product;
                    var rawMaterials = data.rawMaterials;

                    $("#editName").val(product.name);
                    $("#editPrice").val(product.price);
                    $("#editDescription").val(product.description);
                    $("#editAvailability").val(product.availability);

                    console.log(product.product_requirements);

                    var appendToList = "";
                    $("#edit-list-raw").html("");
                    $.each(product.product_requirements, (i, e) => {
                        var rawIDs = $("#editRawIDs").val();
                        if (rawIDs === "") {
                            $("#editRawIDs").val(e.raw_material_id);
                        } else {
                            $("#editRawIDs").val(rawIDs + "," + e.raw_material_id);
                        }

                        var pRIDs = $("#editProductReqIDs").val();
                        if (pRIDs === "") {
                            $("#editProductReqIDs").val(e.id);
                        } else {
                            $("#editProductReqIDs").val(pRIDs + "," + e.id);
                        }
                        appendToList += `
                                            <label id="editLabel${e.raw_material_id}">${e.raw_material.name} <input type="number" name='editQuantity${e.raw_material_id}' min="1" value='${e.quantity}' required> <button type="button" class="btn btn-transparent" onclick="editDeleteRequirement(${e.raw_material_id}, '${e.raw_material.name}')"><i class='fa fa-x'></i></button><br></label>
                                        `;
                    });

                    $("#edit-list-raw").append(appendToList);

                    var addOption = "";
                    $.each(rawMaterials, (i, e) => {
                        addOption = $("<option>", {
                            value: `${e.id}`,
                            text: `${e.name}`
                        });
                        $("#edit-select-list-raw").append(addOption);
                    });


                    var selectHasNoOptions = $("#edit-select-list-raw option").length !== 0;

                    if (selectHasNoOptions) {
                        $("#edit-select-list-raw").attr('disabled', false);
                        $("#editAddRaw").attr('disabled', false);
                    }

                    $("#mdlEdit").modal('show');
                }
            });
        }


        var deleteProduct = (id) => {
            Swal.fire({
                title: 'Delete?',
                text: 'Are you sure you want to delete?',
                icon: 'question',
                showCancelButton: true
            }).then((res)=>{
                if(res.isConfirmed)
                {
                    $.ajax({
                        url: "{{ route('products.delete') }}",
                        type: 'post',
                        data: {id:id},
                        dataType: 'html',
                        success: (data) => {
                            table.ajax.reload(null, false);
                        }
                    });
                }
            });
        }
    </script>
@endsection
