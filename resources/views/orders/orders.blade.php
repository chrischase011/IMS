@extends('layouts.app')

@section('content')
    <style>
        body {
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("https://png.pngtree.com/background/20231017/original/pngtree-3d-illustration-of-a-forklift-operating-inside-a-warehouse-picture-image_5585931.jpg");
            background-size: cover;
            background-position: center;
            font-family: 'Montserrat', sans-serif;
        }
    </style>

    <div class="container bg-white py-3 ">
        <h3>My Orders</h3>

        @include('inc.alert')

        <div class="row my-3 justify-content-center">
            <div class="col-12 table-responsive">
                <table class="table table-light table-bordered table-striped" id="table">
                    <thead>
                        <tr>
                            <th>Order Number</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Date Ordered</th>
                            <th>Payment Status</th>
                            <th>Order Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>{{ $order->customers->firstname . ' ' . $order->customers->lastname }}</td>
                                <td>₱{{ $order->total_amount }}</td>
                                <td>{{ date('F d, Y', strtotime($order->created_at)) }}</td>


                                <td>
                                    @switch($order->is_paid)
                                        @case(0)
                                            <span class="badge bg-danger">Not Paid</span>
                                        @break

                                        @case(1)
                                            <span class="badge bg-success">Paid</span>
                                        @break

                                        @default
                                    @endswitch

                                </td>
                                <td>
                                    @switch($order->order_status)
                                        @case(0)
                                            <span class="badge bg-secondary">Pending</span>
                                        @break

                                        @case(1)
                                            <span class="badge bg-info">Processing</span>
                                        @break

                                        @case(2)
                                            <span class="badge bg-warning">Shipped</span>
                                        @break

                                        @case(3)
                                            <span class="badge bg-success">Received</span>
                                        @break

                                        @case(4)
                                            <span class="badge bg-danger">Cancelled</span>
                                        @break

                                        @default
                                    @endswitch
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm"
                                        onclick="viewOrder({{ $order->id }})" title="View Order"><i
                                            class="fa fa-eye"></i></button>

                                    @if ($order->order_status == 2)
                                        <button type="button" class="btn btn-success btn-sm text-white"
                                            onclick="orderReceived({{ $order->id }})" title="Order Received">Order
                                            Received</button>
                                    @endif
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

            table = $("#table").DataTable({
                responsive: true,
                width: '100%',
                order: [
                    [0, 'desc']
                ],
                language: {
                    loadingRecords: "Fetching Data... Please Wait!"
                },
                columnDefs: [{
                    orderable: false,
                    target: 6
                }]
            });
        });
        var pageTitle = "";
        var viewOrder = (id) => {
            $.ajax({
                url: "{{ route('orders.viewOrder') }}",
                type: 'post',
                data: {
                    id: id
                },
                dataType: 'json',
                success: (data) => {
                    pageTitle = "Print " + data.order_number;
                    $(".order_number").text(data.order_number);
                    var tr = data.transaction_number ? "Transaction No.: " + data.transaction_number : '';
                    $(".transaction_number").text(tr);
                    $("#customer_name").val(data.customers.firstname + ' ' + data.customers.lastname);
                    $("#customer_email").val(data.customers.email);
                    $("#customer_phone").val(data.customers.phone);
                    $("#order_date").val(moment(data.order_date).format('MMM. D, YYYY'));
                    $("#shipping_address").val(data.shipping_address);

                    var html = "";
                    $("#productContainer").html("");
                    $.each(data.order_details, (i, e) => {
                        var totalPrice = parseFloat(e.unit_price) * parseFloat(e.quantity);
                        html += `
                    <tr>
                        <td>${data.products[i].name}</td>
                        <td>${e.quantity}</td>
                        <td>₱${e.unit_price}</td>
                        <td>₱${totalPrice.toFixed(2)}</td>
                    </tr>
                `;
                    });
                    $("#productContainer").append(html);

                    // switch (data.printing_service) {
                    //     case 0:
                    //         $("#printing_category").text("No Design");
                    //         $("#printing_cost").text("₱0.00");
                    //         break;

                    //     case 1:
                    //         $("#printing_category").text("Minimal");
                    //         $("#printing_cost").text("₱80.00");
                    //         break;

                    //     case 2:
                    //         $("#printing_category").text("Half Box");
                    //         $("#printing_cost").text("₱120.00");
                    //         break;

                    //     case 3:
                    //         $("#printing_category").text("Full Box");
                    //         $("#printing_cost").text("₱200.00");
                    //         break;
                    // }

                    $("#printing_cost").text("₱" + data.printing_service.toFixed(2));
                    $("#printing_notes").text(data.printing_notes);

                    $("#gross_amount").val("₱" + data.gross_amount);
                    $("#vat").val("₱" + data.vat);
                    $("#total_amount").val("₱" + data.total_amount);

                    $("#viewOrder").modal('show');
                }
            });
        }

        var orderReceived = (id) => {
            Swal.fire({
                title: "Received?",
                text: "Did you already received your order?",
                icon: 'question',
                showCancelButton: true
            }).then((res) => {
                if (res.isConfirmed) {
                    $.ajax({
                        url: "{{ route('orders.received') }}",
                        type: 'post',
                        data: {
                            id: id
                        },
                        dataType: 'html',
                        success: (data) => {
                            window.location.reload();
                        }
                    });
                }
            });


        }
    </script>

    <div class="modal fade" id="viewOrder">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Order <span class="fw-bold order_number"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h2 class="h5 mb-3 order_number"></h2>
                    <h2 class="h5 mb-3 transaction_number"></h2>
                    <hr>
                    <div class="row">
                        <h2 class="h5 mb-3">Customer Information</h2>
                        <div class="col-6">
                            <div class="row">
                                <label class="col-12">Customer Name</label>
                                <div class="col-12">
                                    <input type="text" id="customer_name" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="row my-3">
                                <label class="col-12">Customer Email</label>
                                <div class="col-12">
                                    <input type="text" id="customer_email" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="row my-3">
                                <label class="col-12">Customer Phone</label>
                                <div class="col-12">
                                    <input type="text" id="customer_phone" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <label class="col-12">Order Date</label>
                                <div class="col-12">
                                    <input type="text" id="order_date" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="row my-3">
                                <label class="col-12">Shipping Address</label>
                                <div class="col-12">
                                    <input type="text" id="shipping_address" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <h2 class="h5 mb-3">Ordered Products</h2>
                        <div class="col-12 table-responsive">
                            <table class="table table-light table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Qty</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody id="productContainer">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <h2 class="h5 mb-3">Additional Printing Service</h2>
                        <div class="col-12">
                            <p class="fw-bold" id="printing_category"></p>
                            <p>Cost: <span class="fw-bold" id="printing_cost"></span></p>
                            <p>Notes: <span class="fw-bold" id="printing_notes"></span></p>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <h2 class="h5 mb-3">Payment</h2>
                        <div class="col-12">
                            <div class="row">
                                <label class="col-12">Subtotal</label>
                                <div class="col-12">
                                    <input type="text" id="gross_amount" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="row my-3">
                                <label class="col-12">Vat</label>
                                <div class="col-12">
                                    <input type="text" id="vat" class="form-control" readonly>
                                </div>
                            </div>

                            <div class="row my-3">
                                <label class="col-12">Total Amount</label>
                                <div class="col-12">
                                    <input type="text" id="total_amount" class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                {{--
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning float-end" id="printOrder"><i class="fa fa-print"></i>
                        Print Order</button>
                </div> --}}

                <script>
                    $(() => {
                        $("#printOrder").on('click', () => {
                            $(".modal-body").printThis({
                                pageTitle: pageTitle,
                            });
                        });
                    });
                </script>

            </div>
        </div>
    </div>
@endsection
