<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Product_in;
use App\Models\Product_out;
use App\Models\Shopkeepers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class StockReportController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Stock-Report';
        if (session()->exists("loginId")) {
            $reportType = $request->input('report_type', 'daily');
            $shopkeeper = Shopkeepers::where("ShopkeeperId", session()->get("loginId"))->first();

            // Determine the date range based on the report type
            $startDate = null;
            $endDate = Carbon::now()->endOfDay();

            switch ($reportType) {
                case 'daily':
                    $startDate = Carbon::today()->startOfDay();
                    break;

                case 'weekly':
                    $startDate = Carbon::now()->subWeek()->startOfDay();
                    break;

                case 'monthly':
                    $startDate = Carbon::now()->subMonth()->startOfDay();
                    break;
            }

            // Fetch all products
            $products = Products::all();
            $stockData = [];

            foreach ($products as $product) {
                // Calculate total stock movements for the period
                $periodTotalIn = Product_in::where('ProductCode', $product->ProductCode)
                    ->whereBetween('DateTime', [$startDate, $endDate])
                    ->sum('Quantity');

                $periodTotalOut = Product_out::where('ProductCode', $product->ProductCode)
                    ->whereBetween('DateTime', [$startDate, $endDate])
                    ->sum('Quantity');

                // Calculate all-time totals for available stock
                $allTimeTotalIn = Product_in::where('ProductCode', $product->ProductCode)
                    ->sum('Quantity');

                $allTimeTotalOut = Product_out::where('ProductCode', $product->ProductCode)
                    ->sum('Quantity');

                // Calculate total prices for the period
                $totalPriceIn = Product_in::where('ProductCode', $product->ProductCode)
                    ->whereBetween('DateTime', [$startDate, $endDate])
                    ->sum('TotalPrice');

                $totalPriceOut = Product_out::where('ProductCode', $product->ProductCode)
                    ->whereBetween('DateTime', [$startDate, $endDate])
                    ->sum('TotalPrice');

                $stockData[] = [
                    'ProductCode' => $product->ProductCode,
                    'ProductName' => $product->ProductName,
                    'TotalIn' => $periodTotalIn,
                    'TotalOut' => $periodTotalOut,
                    'AvailableStock' => $allTimeTotalIn - $allTimeTotalOut,
                    'TotalPriceIn' => $totalPriceIn,
                    'TotalPriceOut' => $totalPriceOut
                ];
            }

            // Convert array to collection for easier manipulation in the view
            $stockData = collect($stockData);

            return view('stock-report.index', compact('stockData', 'reportType', 'shopkeeper', 'title'));
        }
    }
}
