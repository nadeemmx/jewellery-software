@extends('layouts.app')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Invoice #{{ $invoice->id }}</h1>

    <p class="text-gray-600 mb-4">Customer: {{ $invoice->customer_name ?? 'Walk-in' }}</p>
    <p class="text-gray-600 mb-4">Date: {{ $invoice->created_at->format('M d, Y h:i A') }}</p>
    <p class="text-gray-600 mb-4">Branch: {{ $invoice->branch?->name ?? 'Head Office' }}</p>

    <div class="bg-white rounded p-4 mb-4 shadow">
        <h2 class="font-semibold mb-3">Invoice Items</h2>
        <table class="min-w-full table-auto">
            <thead>
                <tr class="border-b">
                    <th class="p-2">Item</th>
                    <th class="p-2">Metal</th>
                    <th class="p-2">Purity</th>
                    <th class="p-2">Weight (g)</th>
                    <th class="p-2">Stone</th>
                    <th class="p-2">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-2">{{ $item->metal_type }}</td>
                    <td class="p-2">{{ $item->purity }}</td>
                    <td class="p-2">₹{{ number_format($item->line_total, 2) }}</td>
                    <td class="p-2">{{ number_format($item->net_weight, 2) }}</td>
                    <td class="p-2">₹{{ number_format($item->stone_charge, 2) }}</td>
                    <td class="p-2 font-bold">₹{{ number_format($item->line_total + $item->stone_charge, 2) }}</td>
                </tr>
                @endforeach
                @if(count($items) == 0)
                <tr>
                    <td class="p-2" colspan="6">No items found</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded p-4 shadow">
        <h3 class="font-semibold mb-3">Totals</h3>
        <p>Subtotal: ₹{{ number_format($invoice->grand_total - $invoice->tax_total, 2) }}</p>
        <p>CGST ({{ $invoice->tax_total / $invoice->grand_total * 100 | round }}%): ₹{{ number_format($invoice->cgst_portion ?? 0, 2) }}</p>
        <p>SGST ({{ $invoice->tax_total / $invoice->grand_total * 100 | round }}%): ₹{{ number_format($invoice->sgst_portion ?? 0, 2) }}</p>
        <p class="font-bold mt-2">Grand Total: ₹{{ number_format($invoice->grand_total, 2) }}</p>
    </div>
</div>
@endsection