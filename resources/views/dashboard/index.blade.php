@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Summary Stats -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Summary Statistics</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metric</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Total Stock In</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">{{ number_format($totalStockStats['totalProductsIn']) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">rwf {{ number_format($totalStockStats['totalStockValueIn'], 2) }}</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Total Stock Out</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">{{ number_format($totalStockStats['totalProductsOut']) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">rwf {{ number_format($totalStockStats['totalStockValueOut'], 2) }}</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Current Stock</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">{{ number_format($totalStockStats['currentStock']) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">rwf {{ number_format($totalStockStats['totalStockValueOut'], 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">-</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Net Stock Value</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">-</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">rwf {{ number_format($totalStockStats['totalStockValueIn'] - $totalStockStats['totalStockValueOut'], 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Products Table -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Top Products</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Total Value</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($topProducts as $product)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $product->ProductName }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">{{ number_format($product->total_quantity) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">rwf {{ number_format($product->total_value, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Transactions Table -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Recent Transactions</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentTransactions as $transaction)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->DateTime->format('Y-m-d H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->product->ProductName }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">{{ number_format($transaction->Quantity) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">rwf {{ number_format($transaction->TotalPrice, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
