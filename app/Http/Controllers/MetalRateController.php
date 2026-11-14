<?php

namespace App\Http\Controllers;

use App\Models\MetalRate;
use Illuminate\Http\Request;

class MetalRateController extends Controller
{
    public function index()
    {
        $rates = MetalRate::where('status', 'approved')
            ->orderBy('metal_type')
            ->orderBy('purity')
            ->get();

        return view('rates.index', compact('rates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'metal_type' => 'required|string|max:30',
            'purity' => 'required|string|max:20',
            'rate_per_gram' => 'required|numeric|min:0',
            'effective_at' => 'nullable|date',
            'status' => 'required|string|max:20',
        ]);

        MetalRate::create($validated);

        return back()->with('success', 'Metal rate added successfully.');
    }

    public function syncLiveRates()
    {
        // Public edition: uses fallback data only, no external API
        $metals = ['Gold' => ['24K', '22K', '20K', '18K', '14K', '9K'],
                   'Silver' => ['999', '925'],
                   'Platinum' => ['950']];

        foreach ($metals as $type => $purities) {
            foreach ($purities as $purity) {
                $rate = MetalRate::firstOrNew([
                    'metal_type' => $type,
                    'purity' => $purity,
                ]);
                $rate->rate_per_gram = rand(4500, 6500); // Demo rate
                $rate->effective_at = now();
                $rate->status = 'approved';
                $rate->save();
            }
        }

        return back()->with('success', 'Metal rates synced with demo data.');
    }

    public function approve($id)
    {
        MetalRate::where('id', $id)->update(['status' => 'approved']);
        return back()->with('success', 'Rate approved.');
    }

    public function destroy($id)
    {
        MetalRate::where('id', $id)->delete();
        return back()->with('success', 'Rate deleted.');
    }
}