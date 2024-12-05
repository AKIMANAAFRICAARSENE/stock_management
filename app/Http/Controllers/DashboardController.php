<?php

namespace App\Http\Controllers;

use App\Models\Product_in;
use App\Models\Product_out;
use App\Models\Products;
use App\Models\Shopkeepers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!session()->exists('loginId')) {
            return redirect('login')->with("fail", "Login first to access this page!");
        }

        $shopkeeper = Shopkeepers::where("ShopkeeperId", session()->get('loginId'))->first();
        $title = "Dashboard"; // Add title for the layout

        // Calculate total stock statistics
        $totalStockStats = [
            'totalProductsIn' => Product_in::sum('Quantity'),
            'totalProductsOut' => Product_out::sum('Quantity'),
            'totalStockValueIn' => Product_in::sum(DB::raw('Quantity * UnitPrice')),
            'totalStockValueOut' => Product_out::sum(DB::raw('Quantity * UnitPrice')),
            'currentStock' => Product_in::sum('Quantity') - Product_out::sum('Quantity'),
        ];

        // Get monthly statistics for the current year
        $monthlyStats = Product_in::select(
            DB::raw('MONTH(DateTime) as month'),
            DB::raw('SUM(Quantity) as total_quantity'),
            DB::raw('SUM(Quantity * UnitPrice) as total_value')
        )
        ->whereYear('DateTime', Carbon::now()->year)
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Get top products by value
        $topProducts = Product_in::select(
            'products.ProductName',
            DB::raw('SUM(product_ins.Quantity) as total_quantity'),
            DB::raw('SUM(product_ins.Quantity * product_ins.UnitPrice) as total_value')
        )
        ->join('products', 'products.ProductCode', '=', 'product_ins.ProductCode')
        ->groupBy('products.ProductName')
        ->orderByDesc('total_value')
        ->limit(5)
        ->get();

        // Recent transactions
        $recentTransactions = Product_in::with('product')
            ->orderBy('DateTime', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.index', compact(
            'totalStockStats',
            'monthlyStats',
            'topProducts',
            'recentTransactions',
            'shopkeeper',
            'title'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
