<?php

namespace App\Http\Controllers;

use App\Models\Product_in;
use App\Models\Product_out;
use App\Models\Products;
use App\Models\Shopkeepers;
use Illuminate\Http\Request;

class ProductOutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (session()->exists('loginId')) {
            $shopkeeper = Shopkeepers::where("ShopkeeperId", session()->get('loginId'))->first();
            $productOuts = Product_out::all();
            return view('product-out.index', compact('productOuts', 'shopkeeper'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (session()->exists('loginId')) {
            $shopkeeper = Shopkeepers::where("ShopkeeperId", session()->get('loginId'))->first();
            $products = Products::all(); // To show available products
            return view('product-out.create', compact('products', 'shopkeeper'));
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
            'Quantity' => 'required|integer|min:1',
            'UnitPrice' => 'required|numeric|min:0',
        ]);

        // Calculate the total stock available for the product
        $productCode = $validatedData['ProductCode'];

        // Sum of quantities from ProductIn
        $totalIn = Product_in::where('ProductCode', $productCode)->sum('Quantity');

        // Sum of quantities from ProductOut
        $totalOut = Product_out::where('ProductCode', $productCode)->sum('Quantity');

        // Available stock = total in - total out
        $availableStock = $totalIn - $totalOut;

        // Check if the requested Quantity to remove exceeds the available stock
        if ($validatedData['Quantity'] > $availableStock) {
            return redirect()->back()->withErrors(['Quantity' => 'Not enough stock available for this product.']);
        }

        // If there's enough stock, proceed to store the ProductOut entry
        $totalPrice = $validatedData['Quantity'] * $validatedData['UnitPrice'];
        Product_out::create(array_merge($validatedData, ['TotalPrice' => $totalPrice]));

        $product = Product_in::where('ProductCode', $productCode)->first();
        $product->Quantity -= $validatedData['Quantity'];
        $product->save();

        return redirect()->route('product-out.index')->with('success', 'ProductOut created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product_out $product_out)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product_out $product_out)
    {
        if (session()->exists('loginId')) {
            $shopkeeper = Shopkeepers::where("ShopkeeperId", session()->get('loginId'))->first();
            $productOut = Product_out::findOrFail($product_out->id);
            $products = Products::all();
            return view('product-out.edit', compact('productOut', 'products', 'shopkeeper'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product_out $product_out)
    {
        $productOut = Product_out::findOrFail($product_out->id);

        $validatedData = $request->validate([
            'ProductCode' => 'required|exists:products,ProductCode',
            'DateTime' => 'required|date',
            'Quantity' => 'required|integer|min:1',
            'UnitPrice' => 'required|numeric|min:0',
        ]);

        $productCode = $validatedData['ProductCode'];

        // Sum of quantities from ProductIn
        $totalIn = Product_in::where('ProductCode', $productCode)->sum('Quantity');

        // Sum of quantities from ProductOut, excluding the current record being edited
        $totalOut = Product_out::where('ProductCode', $productCode)->where('id', '!=', $product_out->id)->sum('Quantity');

        // Available stock
        $availableStock = $totalIn - $totalOut;

        // Check if the requested Quantity to remove exceeds the available stock
        if ($validatedData['Quantity'] > $availableStock) {
            return redirect()->back()->withErrors(['Quantity' => 'Not enough stock available for this product.']);
        }

        // If valid, update the ProductOut entry
        $totalPrice = $validatedData['Quantity'] * $validatedData['UnitPrice'];
        $productOut->update(array_merge($validatedData, ['TotalPrice' => $totalPrice]));


        return redirect()->route('product-out.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product_out $product_out)
    {
        $productOut = Product_out::findOrFail($product_out->id);
        $productOut->delete();

        return redirect()->route('product-out.index')->with('success', 'ProductOut deleted successfully.');
    }
}
