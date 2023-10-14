@extends('layouts.app')

@section('content')
<style>
    body {
        background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url("https://images.pexels.com/photos/4483610/pexels-photo-4483610.jpeg?cs=srgb&dl=pexels-tiger-lily-4483610.jpg&fm=jpg");
        background-size: cover;
        background-position: center;
        font-family: 'Montserrat', sans-serif;
    }

    .bg-daily{
        background-color:#70e06a;
    }

    .bg-monthly{
        background-color: #efc14e;
    }

    .bg-annual{
        background-color: #43c9f2;
    }
</style>

<div class="container bg-white py-3 ">
    <h3>Reports Dashboard</h3>
    <div class="row justify-content-center py-3">
        <div class="col-4">
            <div class="card bg-daily text-white">
                <div class="card-header">
                    <p class="card-title text-center h4 fw-bold">Daily Sales</p>
                </div>
                <div class="card-body">
                    <p class="text-center fw-bold h4">₱{{number_format($dailySales->total_sales ,2)}}</p>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card bg-monthly text-white">
                <div class="card-header">
                    <p class="card-title text-center h4 fw-bold">Monthly Sales</p>
                </div>
                <div class="card-body">
                    <p class="text-center fw-bold h4">₱{{number_format($monthlySales->total_sales ,2)}}</p>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card bg-annual text-white">
                <div class="card-header">
                    <p class="card-title text-center h4 fw-bold">Annual Sales</p>
                </div>
                <div class="card-body">
                    <p class="text-center fw-bold h4">₱{{number_format($totalYearlySales ,2)}}</p>
                </div>
            </div>
        </div>
        <div class="col-4 my-3">
            <div class="card bg-primary text-white">
                <div class="card-header">
                    <p class="card-title text-center h4 fw-bold">Products</p>
                </div>
                <div class="card-body">
                    <p class="text-center fw-bold h4">{{ $counts['products'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-4 my-3">
            <div class="card bg-warning text-white">
                <div class="card-header">
                    <p class="card-title text-center h4 fw-bold">Raw Materials</p>
                </div>
                <div class="card-body">
                    <p class="text-center fw-bold h4">{{ $counts['raw_materials'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-4 my-3">
            <div class="card bg-success text-white">
                <div class="card-header">
                    <p class="card-title text-center h4 fw-bold">Orders</p>
                </div>
                <div class="card-body">
                    <p class="text-center fw-bold h4">{{ $counts['orders'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-4 my-3">
            <div class="card bg-secondary text-white">
                <div class="card-header">
                    <p class="card-title text-center h4 fw-bold">Suppliers</p>
                </div>
                <div class="card-body">
                    <p class="text-center fw-bold h4">{{ $counts['suppliers'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-4 my-3">
            <div class="card bg-dark text-white">
                <div class="card-header">
                    <p class="card-title text-center h4 fw-bold">Customers</p>
                </div>
                <div class="card-body">
                    <p class="text-center fw-bold h4">{{ $counts['customers'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center my-3">
        <div class="col-12">
            <h3>Monthly Sales Chart</h3>
            <canvas id="monthlySalesChart"></canvas>

            <script>
                var chartData = @json($monthlyChartData);

                var labels = chartData.map(function(data) {
                    return data.month;
                });

                var totalSalesData = chartData.map(function(data) {
                    return data.totalSales;
                });

                var salesCountData = chartData.map(function(data) {
                    return data.salesCount;
                });

                var ctx = document.getElementById('monthlySalesChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Total Sales',
                                data: totalSalesData,
                                fill: false,
                                borderColor: 'rgb(75, 192, 192)',
                                tension: 0.1
                            }
                        // {
                            //     label: 'Sales Count',
                            //     data: salesCountData,
                            //     fill: false,
                            //     borderColor: 'rgb(192, 75, 75)',
                            //     tension: 0.1
                            // }
                        ]
                    }
                });
            </script>
        </div>
    </div>

    <div class="row justify-content-center my-3">
        <div class="col-12">
            <h3>Annual Sales Chart</h3>
            <canvas id="yearlySalesChart"></canvas>

            <script>
                var chartData = @json($yearlyChartData);

                var labels = chartData.map(function(data) {
                    return data.year;
                });

                var totalSalesData = chartData.map(function(data) {
                    return data.totalSales;
                });

                var salesCountData = chartData.map(function(data) {
                    return data.salesCount;
                });

                var ctx = document.getElementById('yearlySalesChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Total Sales',
                                data: totalSalesData,
                                fill: false,
                                borderColor: 'rgb(155, 255, 192)',
                                tension: 0.1
                            }
                        // {
                            //     label: 'Sales Count',
                            //     data: salesCountData,
                            //     fill: false,
                            //     borderColor: 'rgb(192, 75, 75)',
                            //     tension: 0.1
                            // }
                        ]
                    }
                });
            </script>
        </div>
    </div>
</div>
@endsection
