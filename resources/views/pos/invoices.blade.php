@extends('layouts.app')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Invoices</h1>

    <div class="bg-white rounded p-4 mb-4 shadow">
        <table class="min-w-full table-auto">
            <thead>
                <tr class="border-b">
                    <th class="p-2">Invoice #</th>
                    <th class="p-2">Customer</th>
                    <th class="p-2">Total</th>
                    <th class="p-2">Date</th>
                    <th class="p-2">Status</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($invoices as $invoice)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-2">{{ $invoice->id }}</td>
                    <td class="p-2">{{ $invoice->customer_name ?? 'Walk-in' }}</td>
                    <td class="p-2">₹{{ number_format($invoice->grand_total, 2) }}</td>
                    <td class="p-2">{{ $invoice->created_at->format('M d, Y') }}</td>
                    <td class="p-2 @if($invoice->status === 'completed')text-green-600@elseif($invoice->status === 'cancelled')text-red-600@elsemerging@fi{{ $invoice->status }}</td>
                    <td class="p-2">
                        <a href="/invoices/{{ $invoice->id }}" class="text-blue-600 underline">View</a>
                        @if(auth()->user()?->role === 'admin')
                        | <form action="/invoices/{{ $invoice->id }}" method="POST" style="display:inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete this invoice?')">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection