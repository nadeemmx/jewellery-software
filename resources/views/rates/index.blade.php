@extends('layouts.app')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold mb-4">Live Metal Rates</h1>

    <div class="bg-white rounded p-4 mb-4 shadow">
        <h2 class="font-semibold mb-3">Gold Rates</h2>
        <table class="min-w-full table-auto">
            <thead>
                <tr class="border-b">
                    <th class="p-2">Purity</th>
                    <th class="p-2">Rate/gram</th>
                    <th class="p-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rates as $rate)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-2">{{ $rate->purity }}</td>
                    <td class="p-2">₹{{ number_format($rate->rate_per_gram, 2) }}</td>
                    <td class="p-2 @if($rate->status === 'approved')text-green-600@elsered-600@fi{{ $rate->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="bg-white rounded p-4 shadow">
        <h2 class="font-semibold mb-3">Silver Rates</h2>
        <table class="min-w-full table-auto">
            <thead>
                <tr class="border-b">
                    <th class="p-2">Purity</th>
                    <th class="p-2">Rate/gram</th>
                    <th class="p-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($silverRates as $rate)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-2">{{ $rate->purity }}</td>
                    <td class="p-2">₹{{ number_format($rate->rate_per_gram, 2) }}</td>
                    <td class="p-2 @if($rate->status === 'approved')text-green-600@elsered-600@fi{{ $rate->status }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        <button onclick="syncRates()" class="btn-primary bg-blue-600 text-white px-4 py-2 rounded">
            Sync Rates (Demo)
        </button>
    </div>
</div>

<script>
function syncRates() {
    // Demo: show alert and simulate sync
    if (confirm('Sync metal rates with demo data?')) {
        window.location.href = '/rates/sync';
    }
}
</script>
@endsection