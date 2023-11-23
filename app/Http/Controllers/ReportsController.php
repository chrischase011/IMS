<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Products;
use App\Models\RawMaterials;
use App\Models\Suppliers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index()
    {
        $cProducts = Products::where('availability', 1)->count();
        $cRawMaterials = RawMaterials::where('availability', 1)->count();
        $cOrders = Orders::count();
        $cSuppliers = Suppliers::count();
        $cCustomers = User::where('roles', 3)->count();
        $cPending = Orders::where('order_status', 0)->count();
        $cCancelled = Orders::where('order_status', 4)->count();
        $cShipped = Orders::where('order_status', 2)->count();
        $cDelivered = Orders::where('order_status', 3)->count();

        $counts = [
            'products' => $cProducts,
            'raw_materials' => $cRawMaterials,
            'orders' => $cOrders,
            'suppliers' => $cSuppliers,
            'customers' => $cCustomers,
            'pending' => $cPending,
            'cancelled' => $cCancelled,
            'shipped' => $cShipped,
            'delivered' => $cDelivered
        ];

        $currentDate = Carbon::now()->format('m/d/Y');

        $dailySales = Orders::select(
            DB::raw('SUM(total_amount) as total_sales'),
            DB::raw('COUNT(*) as sales_count')
        )
            ->where('order_date', $currentDate)->where('is_paid', 1) // Filter by the current date
            ->first();

        $currentDate = now();
        $year = $currentDate->year;
        $month = $currentDate->format('m'); // Get the current month as a zero-padded number

        $monthlySales = Orders::select(
            DB::raw('SUM(total_amount) as total_sales'),
            DB::raw('COUNT(*) as sales_count')
        )
            ->whereRaw("SUBSTRING_INDEX(order_date, '/', -1) = ?", [$year]) // Compare the year part
            ->whereRaw("SUBSTRING_INDEX(order_date, '/', 1) = ?", [$month])   // Compare the month part
            ->where('is_paid', 1)->first();

        $monthNames = [
            '01' => "January",
            '02' => "February",
            '03' => "March",
            '04' => "April",
            '05' => "May",
            '06' => "June",
            '07' => "July",
            '08' => "August",
            '09' => "September",
            '10' => "October",
            '11' => "November",
            '12' => "December",
        ];

        $currentYear = now()->year;

        $monthlySalesData = Orders::select(
            DB::raw('SUM(total_amount) as total_sales'),
            DB::raw('COUNT(*) as sales_count'),
            DB::raw('SUBSTRING_INDEX(order_date, \'/\', 1) as order_month')
        )
            ->whereRaw("SUBSTRING_INDEX(order_date, '/', -1) = ?", [$currentYear])->where('is_paid', 1)
            ->groupBy('order_month')
            ->get();

        $monthlyChartData = [];

        foreach ($monthlySalesData as $sales) {
            $monthlyChartData[] = [
                'month' => $monthNames[$sales->order_month], // Month extracted from the order_date
                'totalSales' => $sales->total_sales,
                'salesCount' => $sales->sales_count,
            ];
        }

        // Convert the data to JSON to be used in your view
        // $monthlyChartData = json_encode($monthlyChartData);

        $yearlySalesData = Orders::select(
            DB::raw('SUM(total_amount) as total_sales'),
            DB::raw('COUNT(*) as sales_count'),
            DB::raw('SUBSTRING_INDEX(SUBSTRING_INDEX(order_date, \'/\', -1), \' \', -1) as order_year')
        )->where('is_paid', 1)
            ->groupBy('order_year')
            ->get();

        $yearlyChartData = [];

        foreach ($yearlySalesData as $sales) {
            $yearlyChartData[] = [
                'year' => $sales->order_year, // Year extracted from the order_date
                'totalSales' => $sales->total_sales,
                'salesCount' => $sales->sales_count,
            ];
        }

        $totalYearlySales = 0;

        foreach ($yearlyChartData as $yearlyData) {
            if ($yearlyData['year'] == $currentYear) {
                $totalYearlySales += $yearlyData['totalSales'];
            }
        }

        // Weekly
        $startOfWeek = $currentDate->startOfWeek()->toDateString();
        $endOfWeek = $currentDate->endOfWeek()->toDateString();


        $weeklySales = Orders::select(
            DB::raw('SUM(total_amount) as total_sales'),
            DB::raw('YEARWEEK(STR_TO_DATE(order_date, "%m/%d/%Y")) as order_week')
        )
            ->whereRaw('STR_TO_DATE(order_date, "%m/%d/%Y") BETWEEN ? AND ?', [$startOfWeek, $endOfWeek])
            ->where('is_paid', 1)
            ->groupBy('order_week')
            ->first();


        return view('reports.index', [
            'counts' => $counts,
            'dailySales' => $dailySales,
            'monthlySales' => $monthlySales,
            'monthlyChartData' => $monthlyChartData,
            'yearlyChartData' => $yearlyChartData,
            'totalYearlySales' => $totalYearlySales,
            'weeklySales' => $weeklySales,
        ]);
    }
}
