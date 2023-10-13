@extends('layouts.blank')

@section('content')
    <div id="invoice" class="container-fluid border">
        <div class="row my-3">
            <div class="col-6 d-flex justify-content-start align-items-center">
                <img src="{{ URL::asset('assets/images/logo.png') }}" class="invoice-logo">
            </div>
            <div class="col-6 d-flex justify-content-end align-items-center">
                <h1 class="h3">Business Invoice</h1>
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
                        <th>Invoice No</th>
                        <th>Date</th>
                    </tr>
                    <tr>
                        <td>{{ $invoice_number }}</td>
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
                                    class="fw-bold">{{ $order->customers->firstname . ' ' . $order->customers->lastname }}</span><br>
                                {{ $order->shipping_address }}<br>
                                {{ $order->customers->phone }}<br>
                                {{ $order->customers->email }}
                            </div>
                        </td>
                        <td>
                            <div class="w-50">
                                {{ $order->shipping_address }}
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

                    @php
                        $i = 0;
                        $n = 1;
                    @endphp

                    @foreach ($order->orderDetails as $detail)
                        <tr>
                            <td>{{ $n++ }}</td>
                            <td>{{ $order->products[$i]->name }}</td>
                            <td>{{ $detail->quantity }}</td>
                            <td>₱{{ number_format($detail->unit_price, 2) }}</td>
                            <td>₱{{ number_format($detail->unit_price * $detail->quantity) }}</td>
                        </tr>

                        @php
                            $i++;
                        @endphp
                    @endforeach


                    <tr>
                        <td>{{ $n++ }}</td>
                        <td colspan="3">
                            @php
                                $amount = 0;
                            @endphp
                            Printing Service:
                            <span class="fw-bold">
                                @switch($order->printing_service)
                                    @case(0)
                                        No Design
                                        @php
                                            $amount = 0;
                                        @endphp
                                    @break

                                    @case(1)
                                        Minimal
                                        @php
                                            $amount = 80;
                                        @endphp
                                    @break

                                    @case(2)
                                        Half Box
                                        @php
                                            $amount = 120;
                                        @endphp
                                    @break

                                    @case(3)
                                        Full Box
                                        @php
                                            $amount = 200
                                        @endphp
                                    @break

                                    @default
                                @endswitch
                            </span>
                        </td>
                        <td>₱{{ number_format($amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-end fw-bold">Subtotal</td>
                        <td>₱{{ number_format($order->gross_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-end fw-bold">Vat</td>
                        <td>₱{{ number_format($order->vat, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-end fw-bold">Total Amount</td>
                        <td>₱{{ number_format($order->total_amount, 2) }}</td>
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
            $("#invoice").printThis({
                pageTitle: "{{ $invoice_number }}"
            });
        });
    </script>
@endsection
