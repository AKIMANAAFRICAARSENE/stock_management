@extends('layouts.app')

@section('title', 'View Product In')

@section('content')
    <h1>Product In Details</h1>

    <div>
        <strong>Product Code:</strong> {{ $productIn->ProductCode }}<br>
        <strong>Product Name:</strong> {{ $productIn->product->ProductName }}<br>
        <strong>Date:</strong> {{ $productIn->DateTime }}<br>
        <strong>Quantity:</strong> {{ $productIn->Quantity }}<br>
        <strong>Unit Price:</strong> ${{ number_format($productIn->UnitPrice, 2) }}<br>
        <strong>Total Price:</strong> ${{ number_format($productIn->TotalPrice, 2) }}<br>
    </div>

    <div>
        <a href="{{ route('product-in.index') }}">Back to Product In List</a>
        <a href="{{ route('product-in.edit', $productIn->id) }}">Edit Product In</a>

        <form action="{{ route('product-in.destroy', $productIn->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Are you sure you want to delete this item?');">Delete</button>
        </form>
    </div>
@endsection

