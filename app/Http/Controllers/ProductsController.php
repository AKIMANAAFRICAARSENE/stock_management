<?php

namespace App\Http\Controllers;

use App\Models\Product_in;
use App\Models\Products;
use App\Models\Shopkeepers;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function index()
    {
        if (session()->exists('loginId')) {
            $title = "Products";
            $header = "XYshop";
            $shopkeeper = Shopkeepers::where("ShopkeeperId", session()->get('loginId'))->first();
            $products = Products::all();
            return view('products.index', compact('products', 'shopkeeper'), ['header' => $header, 'title' => $title]);
        } else {
            return back()->with("fail", "Login first to access this page!");
        };
    }

    public function create()
    {
        if (session()->exists('loginId')) {
            $shopkeeper = Shopkeepers::where("ShopkeeperId", session()->get('loginId'))->first();
            return view('products.create', compact("shopkeeper"));
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ProductCode' => 'required|unique:products',
            'ProductName' => 'required',
        ]);

        Products::create($validatedData);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Products $products)
    {
        //
    }

    public function edit(Products $product)
    {
        if (session()->exists('loginId')) {
            $shopkeeper = Shopkeepers::where("ShopkeeperId", session()->get('loginId'))->first();
            return view('products.edit', compact('product', "shopkeeper"));
        }
    }


    public function update(Request $request, Products $product)
    {
        $validatedData = $request->validate([
            'ProductName' => 'required',
        ]);
        $product->update($validatedData);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Products $product, Request $request)
    {
        $check = Product_in::where('ProductCode', $product->ProductCode)->first();
        if ($check) {
            return redirect()->route('products.index')->with('error', "Can't delete stocked product");
        }
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
