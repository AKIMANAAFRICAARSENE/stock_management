@extends('layouts.app')

@section('title', 'Add Product Out')

@section('content')
@if ($errors->any())
<div class="text-center text-red-600 font-bold">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<h1 class="text-center font-bold">Add Product Out</h1>

<a href="{{ route('product-out.index') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Back to Product Out List</a>
<div class="flex justify-center">

    <form action="{{ route('product-out.store') }}" method="POST" class="border border-slate-600 w-1/2 mt-5 p-5 shadow-xl rounded-md flex flex-col gap-4">
        @csrf
        @method("POST")
        <div>
            <label for="ProductCode">Product Code:</label>
            <select id="ProductCode" name="ProductCode" required class="border border-slate-900 cursor-pointer outline-none px-2">
                <option value="" selected disabled>Select Product</option>
                @foreach($products as $product)
                <option value="{{ $product->ProductCode }}">{{ $product->ProductName }} ({{ $product->ProductCode }})</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="DateTime">Date:</label>
            <input type="datetime-local" id="DateTime" name="DateTime" class="w-60 bg-none rounded-md px-2 border border-slate-400 outline-none" required>
        </div>

        <div>
            <label for="Quantity">Quantity:</label>
            <input type="number" id="Quantity" name="Quantity" class="w-60 bg-none rounded-md px-2 border border-slate-400 outline-none" required>
        </div>

        <div>
            <label for="UnitPrice">Unit Price:</label>
            <input type="number" step="0.01" id="UnitPrice" name="UnitPrice" class="w-60 bg-none rounded-md px-2 border border-slate-400 outline-none" required>
        </div>

        <div>
            <label for="TotalPrice">Total Price:</label>
            <input type="number" step="0.01" id="TotalPrice" name="TotalPrice" class="w-60 bg-none rounded-md px-2 border border-slate-400 outline-none" readonly>
        </div>

        <button type="submit" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Record Product Out</button>
    </form>

</div>

<script>
    document.getElementById('Quantity').addEventListener('input', calculateTotalPrice);
    document.getElementById('UnitPrice').addEventListener('input', calculateTotalPrice);

    function calculateTotalPrice() {
        const quantity = document.getElementById('Quantity').value;
        const unitPrice = document.getElementById('UnitPrice').value;
        const totalPrice = document.getElementById('TotalPrice');

        if (quantity && unitPrice) {
            totalPrice.value = (quantity * unitPrice).toFixed(2);
        }
    }
</script>
@endsection
