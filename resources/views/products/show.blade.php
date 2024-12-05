@extends('layouts.app')

@section('content')
    <h1>Product Details</h1>
    <p>Product Code: {{ $product->ProductCode }}</p>
    <p>Product Name: {{ $product->ProductName }}</p>
@endsection

