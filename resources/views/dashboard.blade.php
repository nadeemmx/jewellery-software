@extends('layouts.app')

@section('header', 'Executive Dashboard & Business Analytics')

@section('content')
<div class="space-y-6">
    <!-- Branch Filter -->
    <div class="flex flex-wrap items-center justify-between gap-3">
        <form method="GET" class="flex items-center gap-2">
            <select name="branch_id" onchange="this.form.submit()" class="border border-slate-300 rounded-lg px-3 py-1.5 text-sm bg-white">
                <option value="">All Branches (Consolidated)</option>
                @foreach($branches as $b)
                    <option value="{{ $b->id }}" {{ $branchId == $b->id ? 'selected' : '' }}>{{ $b->name }} ({{ $b->code }})</option>
                @endforeach
            </select>
        </form>
        <div class="flex items-center gap-2 text-xs">
            @if($pendingApprovals > 0)
                <a href="{{ route('admin.security') }}" class="bg-amber-100 text-amber-800 px-3 py-1.5 rounded-full font-medium">
                    ⚠ {{ $pendingApprovals }} Pending Approvals
                </a>
            @endif
            @if($lowConsumables > 0)
                <a href="{{ route('inventory.index') }}" class="bg-rose-100 text-rose-800 px-3 py-1.5 rounded-full font-medium">
                    📦 {{ $lowConsumables }} Low Consumables
                </a>
            @endif
        </div>
    </div>

    <!-- Primary KPIs -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-xs">
            <div class="text-xs font-medium text-slate-500">Total Sales Today</div>
            <div class="text-2xl font-bold text-slate-900 mt-1">₹{{ number_format($todaySales, 0) }}</div>
            <div class="text-xs text-emerald-600 mt-1">Est. Profit: ₹{{ number_format($todayProfitEstimate, 0) }}</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-xs">
            <div class="text-xs font-medium text-slate-500">Current Stock Valuation</div>
            <div class="text-2xl font-bold text-amber-700 mt-1">₹{{ number_format($stockValuation, 0) }}</div>
            <div class="text-xs text-slate-500 mt-1">{{ $availableItems->count() }} pieces in vault</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-xs">
            <div class="text-xs font-medium text-slate-500">Metal Inventory Weight</div>
            <div class="text-xl font-bold text-slate-900 mt-1">{{ number_format($goldWeight, 2) }}g <span class="text-xs font-normal text-amber-600">Gold</span></div>
            <div class="text-xs text-slate-500 mt-1">{{ number_format($silverWeight, 1) }}g Silver · {{ number_format($diamondCarats, 2) }} ct Diamond</div>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-4 shadow-xs">
            <div class="text-xs font-medium text-slate-500">Receivables & Payables</div>
            <div class="text-xl font-bold text-rose-600 mt-1">₹{{ number_format($outstandingCustomer, 0) }} <span class="text-xs font-normal text-slate-500">Due</span></div>
            <div class="text-xs text-slate-500 mt-1">Supplier Due: ₹{{ number_format($supplierOutstanding, 0) }}</div>
        </div>
    </div>

    <!-- Secondary KPIs -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        <div class="bg-white rounded-lg border border-slate-200 p-3">
            <div class="text-[11px] text-slate-500">Gold Sales</div>
            <div class="text-base font-bold text-slate-800">₹{{ number_format($metalSales['Gold']->total ?? 0, 0) }}</div>
        </div>
        <div class="bg-white rounded-lg border border-slate-200 p-3">
            <div class="text-[11px] text-slate-500">Silver Sales</div>
            <div class="text-base font-bold text-slate-800">₹{{ number_format($metalSales['Silver']->total ?? 0, 0) }}</div>
        </div>
        <div class="bg-white rounded-lg border border-slate-200 p-3">
            <div class="text-[11px] text-slate-500">Diamond Sales</div>
            <div class="text-base font-bold text-slate-800">₹{{ number_format($diamondSales, 0) }}</div>
        </div>
        <div class="bg-white rounded-lg border border-slate-200 p-3">
            <div class="text-[11px] text-slate-500">Total Purchases</div>
            <div class="text-base font-bold text-slate-800">₹{{ number_format($totalPurchaseValue, 0) }}</div>
        </div>
        <div class="bg-white rounded-lg border border-slate-200 p-3">
            <div class="text-[11px] text-slate-500">Old Gold Exchange</div>
            <div class="text-base font-bold text-slate-800">{{ $oldGoldCount }} (₹{{ number_format($oldGoldValue, 0) }})</div>
        </div>
        <div class="bg-white rounded-lg border border-slate-200 p-3">
            <div class="text-[11px] text-slate-500">Pending Orders / Repairs</div>
            <div class="text-base font-bold text-slate-800">{{ $pendingOrders }} / {{ $pendingRepairs }}</div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <h2 class="text-sm font-semibold text-slate-800 mb-3">24K Gold Rate Movement (₹/g)</h2>
            <canvas id="rateChart" height="140"></canvas>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <h2 class="text-sm font-semibold text-slate-800 mb-3">Sales vs Purchase Overview (₹)</h2>
            <canvas id="salesPurchaseChart" height="140"></canvas>
        </div>
    </div>

    <!-- Branch & Staff Sales + Recent Invoices -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl border border-slate-200 p-5">
            <h2 class="text-sm font-semibold text-slate-800 mb-3">Branch-wise Sales</h2>
            <div class="space-y-3">
                @foreach($branchSales as $b)
                    <div class="flex items-center justify-between text-sm border-b border-slate-100 pb-2">
                        <div>
                            <div class="font-medium text-slate-800">{{ $b->name }}</div>
                            <div class="text-xs text-slate-400">{{ $b->code }}</div>
                        </div>
                        <div class="font-semibold text-slate-900">₹{{ number_format($b->total_sales ?? 0, 0) }}</div>
                    </div>
                @endforeach
            </div>
            <h2 class="text-sm font-semibold text-slate-800 mt-5 mb-3">Top Salespersons</h2>
            <div class="space-y-2">
                @foreach($staffSales as $s)
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-700">{{ $s->name }}</span>
                        <span class="font-semibold text-amber-700">₹{{ number_format($s->total_sales ?? 0, 0) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 p-5">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-sm font-semibold text-slate-800">Recent Showroom Invoices</h2>
                <a href="{{ route('pos.invoices') }}" class="text-xs text-amber-700 font-medium hover:underline">View All →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-xs text-slate-500 uppercase bg-slate-50">
                        <tr>
                            <th class="px-3 py-2 text-left">Invoice #</th>
                            <th class="px-3 py-2 text-left">Customer</th>
                            <th class="px-3 py-2 text-left">Branch</th>
                            <th class="px-3 py-2 text-right">Amount</th>
                            <th class="px-3 py-2 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentInvoices as $inv)
                            <tr class="hover:bg-slate-50">
                                <td class="px-3 py-2 font-medium"><a href="{{ route('pos.invoice', $inv) }}" class="text-amber-700 hover:underline">{{ $inv->invoice_no }}</a></td>
                                <td class="px-3 py-2">{{ $inv->customer->name ?? 'Walk-in' }}</td>
                                <td class="px-3 py-2 text-slate-500">{{ $inv->branch->code ?? '' }}</td>
                                <td class="px-3 py-2 text-right font-semibold">₹{{ number_format($inv->grand_total, 2) }}</td>
                                <td class="px-3 py-2 text-center">
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-emerald-100 text-emerald-700 capitalize">{{ $inv->status }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-3 py-4 text-center text-slate-400">No invoices yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const rateCtx = document.getElementById('rateChart');
    if (rateCtx && window.Chart) {
        new window.Chart(rateCtx, {
            type: 'line',
            data: {
                labels: @json($rateHistory->map(fn($r) => $r->effective_at->format('d M'))),
                datasets: [{
                    label: '24K Gold (₹/g)',
                    data: @json($rateHistory->pluck('rate_per_gram')),
                    borderColor: '#d97706',
                    backgroundColor: 'rgba(217, 119, 6, 0.1)',
                    fill: true,
                    tension: 0.35
                }]
            },
            options: { plugins: { legend: { display: false } } }
        });
    }

    const spCtx = document.getElementById('salesPurchaseChart');
    if (spCtx && window.Chart) {
        new window.Chart(spCtx, {
            type: 'bar',
            data: {
                labels: ['Total Sales', 'Total Purchases', 'Old Gold Exchange', 'Stock Valuation'],
                datasets: [{
                    label: 'Value (₹)',
                    data: [{{ $totalSales }}, {{ $totalPurchaseValue }}, {{ $oldGoldValue }}, {{ $stockValuation }}],
                    backgroundColor: ['#059669', '#2563eb', '#d97706', '#0f172a'],
                    borderRadius: 6
                }]
            },
            options: { plugins: { legend: { display: false } } }
        });
    }
});
</script>
@endpush

