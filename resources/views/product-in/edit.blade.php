@extends('layouts.app')

@section('title', 'Edit Product In')

@section('content')
<h1 class="font-bold text-center text-xl">Edit Product In</h1>

<!-- Loader -->
<div id="loader" class="loader"></div>

<a href="{{ route('product-in.index') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Back to Product In List</a>

<div class="flex justify-center">
    <form id="productInForm" action="{{ route('product-in.update', $productIn->id) }}" method="POST" class="border border-slate-900 shadow-md rounded-md p-4 w-1/2 flex gap-5 flex-col">
        @csrf
        @method('PUT')

        <div>
            <label for="ProductCode">Product Code:</label>
            <input type="text" name="ProductCode" id="ProductCode" value="{{ old('ProductCode', $productIn->ProductCode) }}" required class="w-60 bg-none rounded-md px-2 border border-slate-400 outline-none" readonly>
        </div>

        <div>
            <label for="DateTime">Date:</label>
            <input type="datetime-local" name="DateTime" id="DateTime" value="{{ old('DateTime', $productIn->DateTime) }}" required class="w-60 bg-none rounded-md px-2 border border-slate-400 outline-none">
        </div>

        <div>
            <label for="Quantity">Quantity:</label>
            <input type="number" name="Quantity" id="Quantity" value="{{ old('Quantity', $productIn->Quantity) }}" required class="w-60 bg-none rounded-md px-2 border border-slate-400 outline-none">
        </div>

        <div>
            <label for="UnitPrice">Unit Price:</label>
            <input type="number" step="0.01" name="UnitPrice" id="UnitPrice" value="{{ old('UnitPrice', $productIn->UnitPrice) }}" required class="w-60 bg-none rounded-md px-2 border border-slate-400 outline-none">
        </div>

        <div>
            <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Update Product In</button>
        </div>
    </form>
</div>

<div>
</div>

@endsection
