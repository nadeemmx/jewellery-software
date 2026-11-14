<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use App\Models\Product; // placeholder for demo
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductInventoryController extends Controller
{
    public function products()
    {
        // Demo product list for public edition
        $products = [
            ['name' => 'Gold Chain', 'metal_type' => 'Gold', 'purity' => '22K', 'rate_per_gram' => 5200, 'stock' => 15],
            ['name' => 'Silver Ring', 'metal_type' => 'Silver', 'purity' => '925', 'rate_per_gram' => 85, 'stock' => 42],
            ['name' => 'Platinum Band', 'metal_type' => 'Platinum', 'purity' => '950', 'rate_per_gram' => 3800, 'stock' => 8],
        ];

        return view('inventory.products', compact('products'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'metal_type' => 'required|string|max:30',
            'purity' => 'required|string|max:20',
            'rate_per_gram' => 'required|numeric|min:0',
        ]);

        // Demo: just redirect back with success
        return back()->with('success', 'Product "' . $validated['name'] . '" added successfully.');
    }

    public function inventory()
    {
        // Demo inventory items
        $items = [
            ['product' => 'Gold Chain', 'metal_type' => 'Gold', 'purity' => '22K', 'net_weight' => 15.5, 'stone_charge' => 500, 'diamond_charge' => 0, 'status' => 'available'],
            ['product' => 'Silver Ring', 'metal_type' => 'Silver', 'purity' => '925', 'net_weight' => 3.2, 'stone_charge' => 0, 'diamond_charge' => 0, 'status' => 'available'],
        ];

        return view('inventory.items', compact('items'));
    }

    public function storeItem(Request $request)
    {
        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'metal_type' => 'required|string|max:30',
            'purity' => 'required|string|max:20',
            'net_weight' => 'required|numeric|min:0',
            'stone_charge' => 'nullable|numeric|min:0',
            'diamond_charge' => 'nullable|numeric|min:0',
            'status' => 'required|string|in:available, reserved, sold',
        ]);

        return back()->with('success', 'Inventory item added successfully.');
    }

    public function labels()
    {
        return view('inventory.labels');
    }

    public function stonesAndHallmarking()
    {
        return view('inventory.stones-hallmark');
    }

    public function storeStone(Request $request)
    {
        $validated = $request->validate([
            'shape' => 'required|string|max:40',
            'carat_weight' => 'required|numeric|min:0',
            'quality' => 'nullable|string|max:50',
        ]);

        return back()->with('success', 'Stone recorded: ' . $validated['shape'] . ' - ' . ($validated['carat_weight'] ?? 0) . ' carat');
    }

    public function destroyStone($id)
    {
        return back()->with('success', 'Stone removed.');
    }
}