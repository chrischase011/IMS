@extends('layouts.blank2')

@section('content')
    <div id="invoice" class="container-fluid border">
        <div class="row my-3">
            <div class="col-6 d-flex justify-content-start align-items-center">
                <img src="{{ URL::asset('assets/images/logo.png') }}" class="invoice-logo">
            </div>
            <div class="col-6 d-flex justify-content-end align-items-center">
                <h1 class="h3">Purchase Order</h1>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-6">
                {{-- Enter your company address here --}}

                <p>
                    Century Cardboard Box Factory & Printing Inc. <br>
                    123 Main Street <br>
                    Caloocan City <br>
                    +639-1234-56789<br>
                    centurycardboard@gmail.com

                </p>
            </div>

            <div class="col-6 ">
                <table class="table table-bordered table-striped text-center">
                    <tr>
                        <th>Date</th>
                    </tr>
                    <tr>
                        <td>{{ date('m/d/Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Bill To</th>
                        <th>Ship To</th>
                    </tr>
                    <tr>
                        <td>
                            <div class="w-50">
                                <span
                                    class="fw-bold">{{ $report->supplier->name }}</span><br>
                                    {{ $report->supplier->contact_name }}<br>
                                {{ $report->supplier->address.', '.$report->supplier->city.' '.$report->supplier->postal_code }}<br>
                                {{ $report->supplier->province .' '.$report->supplier->country }}<br>
                                {{ $report->supplier->contact_email }}<br>
                                {{ $report->supplier->contact_phone }}
                            </div>
                        </td>
                        <td>
                            <div class="w-50">
                                <p>
                                    Century Cardboard Box Factory & Printing Inc. <br>
                                    123 Main Street <br>
                                    Caloocan City <br>
                                    +639-1234-56789<br>
                                    centurycardboard@gmail.com

                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <table class="table table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Amount</th>
                    </tr>

                    <tr>
                        <td>{{ $report->id }}</td>
                        <td>{{ $report->name }}</td>
                        <td>{{ $report->quantity }}</td>
                        <td>{{ $report->price }}</td>
                        <td>
                            ₱{{ number_format($report->price * $report->quantity, 2)  }}
                        </td>
                    </tr>


                    <tr>
                        <td colspan="4" class="text-end fw-bold">Total Amount</td>
                        <td>₱{{ number_format($report->price * $report->quantity, 2)  }}</td>
                    </tr>

                </table>
            </div>
        </div>

        <div class="text-center my-3">
            <small class="fst-italic">
                If you have question or concern, please email us <br>at centurycardboard@gmail.com
                or dial +639-1234-56789.<br> Thank you!
            </small>
        </div>

    </div>

    <script>
        $(() => {
            $("#invoice").printThis();
        });
    </script>
@endsection
