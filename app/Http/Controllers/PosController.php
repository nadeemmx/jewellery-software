<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        return view('pos.index');
    }

    public function calculatePreview(Request $request)
    {
        $validated = $request->validate([
            'metal_type' => 'required|string|max:30',
            'purity' => 'required|string|max:20',
            'gross_weight' => 'required|numeric|min:0',
            'stone_weight' => 'nullable|numeric|min:0',
            'making_charge_type' => 'required|string|in:fixed,percentage',
            'making_charge_rate' => 'required|numeric|min:0',
            'stone_charge' => 'nullable|numeric|min:0',
            'gst_rate' => 'required|numeric|min:0|max:28',
        ]);

        $calc = new \App\Services\JewelleryPriceCalculator();
        $res = $calc->calculateInvoice([[
            'gross_weight' => $validated['gross_weight'],
            'stone_weight' => $validated['stone_weight'] ?? 0,
            'metal_rate' => $validated['making_charge_rate'], // using making charge rate as metal rate for demo
            'making_charge_type' => $validated['making_charge_type'],
            'making_charge_rate' => $validated['making_charge_rate'],
            'stone_charge' => $validated['stone_charge'] ?? 0,
            'gst_rate' => $validated['gst_rate'],
        ]]);

        return response()->json([
            'subtotal' => $res['subtotal'],
            'cgst_amount' => $res['cgst_amount'],
            'sgst_amount' => $res['sgst_amount'],
            'grand_total' => $res['grand_total'],
            'breakdown' => [
                'metal_value' => $res['subtotal'] - $res['cgst_amount'] - $res['sgst_amount'],
                'gst_breakdown' => [
                    'cgst' => $res['cgst_amount'],
                    'sgst' => $res['sgst_amount'],
                ],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'metal_type' => 'required|string|max:30',
            'purity' => 'required|string|max:20',
            'gross_weight' => 'required|numeric|min:0',
            'stone_weight' => 'nullable|numeric|min:0',
            'making_charge_type' => 'required|string|in:fixed,percentage',
            'making_charge_rate' => 'required|numeric|min:0',
            'stone_charge' => 'nullable|numeric|min:0',
            'gst_rate' => 'required|numeric|min:0|max:28',
        ]);

        $calc = new \App\Services\JewelleryPriceCalculator();
        $res = $calc->calculateInvoice([[
            'gross_weight' => $validated['gross_weight'],
            'stone_weight' => $validated['stone_weight'] ?? 0,
            'metal_rate' => $validated['making_charge_rate'],
            'making_charge_type' => $validated['making_charge_type'],
            'making_charge_rate' => $validated['making_charge_rate'],
            'stone_charge' => $validated['stone_charge'] ?? 0,
            'gst_rate' => $validated['gst_rate'],
        ]]);

        // Create invoice
        $invoice = Invoice::create([
            'user_id' => auth()->id(),
            'branch_id' => auth()->user()?->branch_id,
            'customer_name' => $validated['customer_name'],
            'grand_total' => $res['grand_total'],
            'tax_total' => $res['cgst_amount'] + $res['sgst_amount'],
            'status' => 'completed',
        ]);

        // Create invoice items
        InvoiceItem::create([
            'invoice_id' => $invoice->id,
            'metal_type' => $validated['metal_type'],
            'purity' => $validated['purity'],
            'gross_weight' => $validated['gross_weight'],
            'net_weight' => $validated['gross_weight'] - ($validated['stone_weight'] ?? 0),
            'stone_charge' => $validated['stone_charge'] ?? 0,
            'line_total' => $res['subtotal'],
        ]);

        return back()->with('success', 'Invoice created. Total: ₹' . number_format($res['grand_total'], 2));
    }

    public function invoices()
    {
        $invoices = Invoice::where('status', '!=', 'cancelled')
            ->when(auth()->user()?->branch_id, fn ($q) => $q->where('branch_id', auth()->user()?->branch_id))
            ->latest('created_at')
            ->get();

        return view('pos.invoices', compact('invoices'));
    }

    public function showInvoice($id)
    {
        $invoice = Invoice::findOrFail($id);
        $items = InvoiceItem::where('invoice_id', $id)->get();

        return view('pos.invoice-detail', compact('invoice', 'items'));
    }

    public function destroyInvoice($id)
    {
        Invoice::where('id', $id)->delete();
        return back()->with('success', 'Invoice deleted.');
    }

    public function cancelInvoice($id)
    {
        Invoice::where('id', $id)->update(['status' => 'cancelled']);
        return back()->with('success', 'Invoice cancelled.');
    }
}