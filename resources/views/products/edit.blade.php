@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<h1 class="font-bold text-center text-xl">Edit Product</h1>

@if ($errors->any())
<div class="text-center text-red-600 font-bold">>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<a href="{{ route('products.index') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Back to Products List</a>

<div class="flex justify-center">
    <form action="{{ route('products.update', $product->ProductCode) }}" method="POST" class="border border-slate-900 shadow-md rounded-md p-4 w-1/2 flex gap-5 flex-col">
        @csrf
        @method('PUT')

        <div>
            <label for="ProductCode">Product Code:</label>
            <input type="text" id="ProductCode" name="ProductCode" value="{{ old('ProductCode', $product->ProductCode) }}" class="w-60 bg-none rounded-md px-2 border border-slate-400 outline-none" readonly>
        </div>

        <div>
            <label for="ProductName">Product Name:</label>
            <input type="text" id="ProductName" name="ProductName" value="{{ old('ProductName', $product->ProductName) }}" class="w-60 bg-none rounded-md px-2 border border-slate-400 outline-none" required>
        </div>

        <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Update Product</button>
    </form>

</div>
@endsection
