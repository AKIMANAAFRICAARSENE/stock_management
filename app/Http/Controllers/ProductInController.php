<?php

namespace App\Http\Controllers;

use App\Models\Product_in;
use App\Models\Products;
use App\Models\Shopkeepers;
use Illuminate\Http\Request;

class ProductInController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (session()->exists('loginId')) {
            $title = "Stock In";
            $productIns = Product_in::with('product')->get();
            $shopkeeper = Shopkeepers::where("ShopkeeperId", session()->get('loginId'))->first();
            $productAll = Product_in::all();
            return view('product-in.index', compact('productIns', 'productAll', 'title', 'shopkeeper'));
        } else {
            return back()->with("fail", "Login first to access this page!");
        };
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (session()->exists("loginId")) {
            $shopkeeper = Shopkeepers::where("ShopkeeperId", session()->get("loginId"))->first();

            $products = Products::all();
            return view('product-in.create', compact('products', 'shopkeeper'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ProductCode' => 'required|exists:products,ProductCode',
            'DateTime' => 'required|date',
            'Quantity' => 'required|integer',
            'UnitPrice' => 'required|numeric',
            'TotalPrice' => 'required|numeric',
        ]);

        // Store the product in data
        Product_in::create($validatedData);

        return redirect()->route('product-in.index')->with('success', 'Product added to stock successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product_in $product_in)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product_in $product_in)
    {
        if (session()->exists('loginId')) {
            $shopkeeper = Shopkeepers::where("ShopkeeperId", session()->get('loginId'))->first();
            $productIn = Product_in::findOrFail($product_in->id);

            // Pass the productIn data to the view
            return view('product-in.edit', compact('productIn', 'shopkeeper'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product_in $product_in)
    {
        $request->validate([
            'ProductCode' => 'required|string|max:255',
            'DateTime' => 'required|date',
            'Quantity' => 'required|integer',
            'UnitPrice' => 'required|numeric',
        ]);

        // Find the ProductIn record by its ID
        $productIn = Product_in::findOrFail($product_in->id);

        // Update the ProductIn record with the new data
        $productIn->ProductCode = $request->ProductCode;
        $productIn->DateTime = $request->DateTime;
        $productIn->Quantity = $request->Quantity;
        $productIn->UnitPrice = $request->UnitPrice;
        $productIn->TotalPrice = $request->Quantity * $request->UnitPrice;

        // Save the changes
        $productIn->save();

        // Redirect to the product-in index with a success message
        return redirect()->route('product-in.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product_in $product_in)
    {
        $productIn = Product_in::findOrFail($product_in->id);
        $productIn->delete();
        return redirect()->route('product-in.index')->with('success', 'deleted successfully');
    }
}
