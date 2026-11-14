@extends('layouts.app')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Inventory Items</h1>

    <div class="bg-white rounded p-4 mb-4 shadow">
        <h2 class="font-semibold mb-3">Add New Item</h2>
        <form class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Product Name</label>
                <input type="text" name="product_name" required
                    class="mt-1 block w-full rounded border">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Metal Type</label>
                <select name="metal_type" class="mt-1 block w-full rounded border" required>
                    <option value="Gold">Gold</option>
                    <option value="Silver">Silver</option>
                    <option value="Platinum">Platinum</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Purity</label>
                <select name="purity" class="mt-1 block w-full rounded border" required>
                    <option value="24K">24K</option>
                    <option value="22K">22K</option>
                    <option value="18K">18K</option>
                    <option value="14K">14K</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Net Weight (grams)</label>
                <input type="number" name="net_weight" step="0.01" min="0" required
                    class="mt-1 block w-full rounded">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Stone Charge (₹)</label>
                <input type="number" name="stone_charge" step="0.01" min="0"
                    class="mt-1 block w-full rounded">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Diamond Charge (₹)</label>
                <input type="number" name="diamond_charge" step="0.01" min="0"
                    class="mt-1 block w-full rounded">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Status</label>
                <select name="status" class="mt-1 block w-full rounded border" required>
                    <option value="available">Available</option>
                    <option value="reserved">Reserved</option>
                    <option value="sold">Sold</option>
                </select>
            </div>

            <button type="submit" class="btn-primary bg-green-600 text-white px-4 py-2 rounded">
                Add Item
            </button>
        </form>
    </div>

    <h2 class="font-semibold mt-6">Current Inventory</h2>
    <table class="min-w-full table-auto">
        <thead>
            <tr class="border-b">
                <th class="p-2">Product</th>
                <th class="p-2">Metal</th>
                <th class="p-2">Purity</th>
                <th class="p-2">Weight (g)</th>
                <th class="p-2">Stone</th>
                <th class="p-2">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-2">{{ $item['product'] }}</td>
                <td class="p-2">{{ $item['metal_type'] }}</td>
                <td class="p-2">{{ $item['purity'] }}</td>
                <td class="p-2">{{ number_format($item['net_weight'], 2) }}</td>
                <td class="p-2">₹{{ number_format($item['stone_charge'] ?? 0, 2) }}</td>
                <td class="p-2 @if($item['status'] === 'available')text-green-600@elseif($item['status'] === 'reserved')text-yellow-600@elsered-600@fi{{ $item['status'] }}</td>
            </tr>
            @endforeach
            @if(count($items) == 0)
            <tr>
                <td class="p-2" colspan="6">No inventory items</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection