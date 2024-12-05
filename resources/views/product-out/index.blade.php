@extends('layouts.app')

@section('title', 'Product Out List')

@section('content')
<div class="sm:flex sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Stock Out Records</h1>
        <p class="mt-2 text-sm text-gray-700">A list of all outgoing stock transactions.</p>
    </div>
    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        <a href="{{ route('product-out.create') }}" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Record Stock Out
        </a>
    </div>
</div>

@if (session('success'))
<div class="rounded-md bg-green-50 p-4 mt-4">
    <div class="flex">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="ml-3">
            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
        </div>
    </div>
</div>
@endif

<div class="mt-8 flex flex-col">
    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Product Code</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Product Name</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
                            <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Quantity</th>
                            <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Unit Price</th>
                            <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Total Price</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @if ($productOuts->count())
                            @foreach ($productOuts as $productOut)
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $productOut->ProductCode }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <a href="{{ route('product-out.show', $productOut->id) }}" class="text-indigo-600 hover:text-indigo-900">{{ $productOut->product->ProductName }}</a>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $productOut->DateTime->format('Y-m-d H:i') }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-right text-gray-500">{{ number_format($productOut->Quantity) }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-right text-gray-500">rwf {{ number_format($productOut->UnitPrice, 2) }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-right font-medium text-gray-900">rwf {{ number_format($productOut->TotalPrice, 2) }}</td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <a href="{{ route('product-out.edit', $productOut->id) }}" class="inline-flex items-center px-3 py-1.5 text-indigo-600 hover:text-indigo-900 mr-2">
                                        <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('product-out.destroy', $productOut->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this record?')">
                                            <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    No stock-out records found.
                                    <a href="{{ route('product-out.create') }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Record your first stock out</a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                    @if ($productOuts->count())
                    <tfoot class="bg-gray-50">
                        <tr>
                            <th scope="row" colspan="3" class="hidden sm:table-cell pl-4 pr-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:pl-6">Totals</th>
                            <td class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">{{ number_format($productOuts->sum('Quantity')) }}</td>
                            <td></td>
                            <td class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">rwf {{ number_format($productOuts->sum('TotalPrice'), 2) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

