@extends('layouts.app')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Product Inventory</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
        @foreach ($products as $product)
        <div class="bg-white rounded p-4 shadow hover:hover:border-blue-500 transition">
            <h3 class="font-medium">{{ $product['name'] }}</h3>
            <p class="text-sm text-gray-500">Metal: {{ $product['metal_type'] }}</p>
            <p class="text-sm font-medium">Purity: {{ $product['purity'] }}</p>
            <p class="text-lg font-bold">₹{{ number_format($product['rate_per_gram'], 2 )}}/gram</p>
            <p class="text-sm">Stock: {{ $product['stock'] }}</p>
        </div>
        @endforeach
    </div>

    <a href="/products/create" class="btn-primary bg-green-600 text-white px-4 py-2 rounded">Add New Product</a>
</div>
@endsection