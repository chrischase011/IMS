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
    <h3>Purchase</h3>

    @include('inc.alert')

    <div class="row">
        <div class="col-12 d-flex justify-content-end">
            <a href="{{ route('purchase.index') }}" id="btnAdd" class="btn btn-primary me-3" title="Produce a Product"><i
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
                        <th>Status</th>
                        <th>City</th>
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

    $(()=>{
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
        });
    });
</script>
@endsection