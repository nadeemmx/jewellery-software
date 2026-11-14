@extends('layouts.app')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Label Printing</h1>

    <p class="text-gray-600 mb-4">Label printing functionality for inventory items.</p>

    <div class="bg-white rounded p-4 shadow">
        <h2 class="font-semibold mb-3">Label Configuration</h2>
        <p>Select an item to generate a price label.</p>

        <form class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Select Item</label>
                <select name="item" class="mt-1 block w-full rounded border">
                    <option value="">-- Select Item --</option>
                    <option value="gold-chain">Gold Chain - 22K, 15.5g</option>
                    <option value="silver-ring">Silver Ring - 925, 3.2g</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Label Type</label>
                <select name="type" class="mt-1 block w-full rounded border">
                    <option value="price">Price Label</option>
                    <option value="inventory">Inventory Label</option>
                </select>
            </div>

            <button type="submit" class="btn-primary bg-blue-600 text-white px-4 py-2 rounded">
                Generate Label
            </button>
        </form>
    </div>
</div>
@endsection