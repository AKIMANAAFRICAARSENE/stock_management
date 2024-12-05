@extends('layouts.app')

@section('content')
<div class="container">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Stock Report</h1>
            <p class="mt-2 text-sm text-gray-700">A detailed view of your inventory movements and current stock levels.</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <button id="print-btn" onclick="window.print()" class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Print Report
            </button>
        </div>
    </div>

    <div class="mt-8 flex items-center">
        <form method="GET" action="{{ route('stock-report.index') }}" class="max-w-xs">
            <label for="report_type" class="block text-sm font-medium text-gray-700">Report Period</label>
            <select name="report_type"
                    id="report_type"
                    onchange="this.form.submit()"
                    class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                <option value="daily" {{ $reportType == 'daily' ? 'selected' : '' }}>Daily Report</option>
                <option value="weekly" {{ $reportType == 'weekly' ? 'selected' : '' }}>Weekly Report</option>
                <option value="monthly" {{ $reportType == 'monthly' ? 'selected' : '' }}>Monthly Report</option>
            </select>
        </form>
    </div>

    <div class="mt-8 flex flex-col">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Product Code</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Product Name</th>
                                <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Stock In</th>
                                <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Stock Out</th>
                                <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Available</th>
                                <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Total In ($)</th>
                                <th scope="col" class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">Total Out ($)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach ($stockData as $data)
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $data['ProductCode'] }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $data['ProductName'] }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-right text-gray-500">{{ number_format($data['TotalIn']) }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-right text-gray-500">{{ number_format($data['TotalOut']) }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-right font-medium {{ $data['AvailableStock'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($data['AvailableStock']) }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-right text-gray-500">rwf {{ number_format($data['TotalPriceIn'], 2) }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-right text-gray-500">rwf {{ number_format($data['TotalPriceOut'], 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <th scope="row" colspan="2" class="hidden sm:table-cell pl-4 pr-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:pl-6">Totals</th>
                                <th scope="row" class="py-3.5 pl-4 pr-3 text-right text-sm font-semibold text-gray-900 sm:hidden" colspan="2">Totals</th>
                                <td class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">{{ number_format($stockData->sum('TotalIn')) }}</td>
                                <td class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">{{ number_format($stockData->sum('TotalOut')) }}</td>
                                <td class="px-3 py-3.5 text-right text-sm font-semibold {{ $stockData->sum('AvailableStock') > 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($stockData->sum('AvailableStock')) }}
                                </td>
                                <td class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">rwf {{ number_format($stockData->sum('TotalPriceIn'), 2) }}</td>
                                <td class="px-3 py-3.5 text-right text-sm font-semibold text-gray-900">rwf {{ number_format($stockData->sum('TotalPriceOut'), 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        .bg-gray-50 { background-color: #f9fafb !important; }
        .shadow { box-shadow: none !important; }
        .ring-1 { border: 1px solid #e5e7eb !important; }
        @page { size: landscape; }
    }
</style>
@endsection
