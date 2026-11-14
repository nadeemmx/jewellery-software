<?php

namespace App\Http\Controllers;

use App\Models\ApprovalRequest;
use App\Models\Branch;
use App\Models\Consumable;
use App\Models\CustomOrder;
use App\Models\DiamondStone;
use App\Models\InventoryItem;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\MetalRate;
use App\Models\OldGoldPurchase;
use App\Models\PurchaseInvoice;
use App\Models\RepairJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $branchId = $request->get('branch_id');
        $today = today();

        $invoiceQuery = Invoice::where('status', '!=', 'cancelled')
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId));

        $todaySales = (clone $invoiceQuery)->whereDate('billed_at', $today)->sum('grand_total');
        $totalSales = (clone $invoiceQuery)->sum('grand_total');
        $outstandingCustomer = (clone $invoiceQuery)->sum('balance_due');

        // Metal-wise sales breakdown
        $metalSales = InvoiceItem::whereHas('invoice', fn ($q) => $q->where('status', '!=', 'cancelled')->when($branchId, fn ($b) => $b->where('branch_id', $branchId)))
            ->select('metal_type', DB::raw('SUM(line_total) as total'), DB::raw('SUM(net_weight) as weight'))
            ->groupBy('metal_type')
            ->get()
            ->keyBy('metal_type');

        $diamondSales = InvoiceItem::whereHas('invoice', fn ($q) => $q->where('status', '!=', 'cancelled')->when($branchId, fn ($b) => $b->where('branch_id', $branchId)))
            ->where('diamond_charge', '>', 0)
            ->sum('line_total');

        // Inventory metrics
        $availableItems = InventoryItem::with('product')
            ->where('status', 'available')
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->get();

        $goldRate22 = MetalRate::latestRate('Gold', '22K', $branchId);
        $goldRate24 = MetalRate::latestRate('Gold', '24K', $branchId);
        $silverRate = MetalRate::latestRate('Silver', '999', $branchId);
        $platinumRate = MetalRate::latestRate('Platinum', '950', $branchId);

        $goldWeight = 0;
        $silverWeight = 0;
        $stockValuation = 0;

        foreach ($availableItems as $item) {
            $metal = $item->product->metal_type ?? 'Gold';
            $rate = MetalRate::latestRate($metal, $item->purity, $item->branch_id) ?: $goldRate22;
            if ($metal === 'Gold') {
                $goldWeight += (float) $item->net_weight;
            } elseif ($metal === 'Silver') {
                $silverWeight += (float) $item->net_weight;
            }
            $stockValuation += ((float) $item->net_weight * $rate) + (float) $item->stone_charge + (float) $item->diamond_charge;
        }

        $diamondCarats = DiamondStone::where('status', 'in_stock')->sum('carat_weight');

        $totalPurchaseValue = PurchaseInvoice::when($branchId, fn ($q) => $q->where('branch_id', $branchId))->sum('total_amount');
        $supplierOutstanding = PurchaseInvoice::when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->selectRaw('COALESCE(SUM(total_amount - paid_amount), 0) as due')
            ->value('due');

        $pendingOrders = CustomOrder::whereIn('status', ['pending_approval', 'approved', 'in_production'])
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))->count();
        $pendingRepairs = RepairJob::whereIn('status', ['received', 'in_progress', 'qc'])
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))->count();
        $oldGoldCount = OldGoldPurchase::when($branchId, fn ($q) => $q->where('branch_id', $branchId))->count();
        $oldGoldValue = OldGoldPurchase::when($branchId, fn ($q) => $q->where('branch_id', $branchId))->sum('valuation_amount');

        $todayProfitEstimate = (clone $invoiceQuery)->whereDate('billed_at', $today)->sum('making_total') * 0.75;

        // Branch-wise & Staff-wise sales
        $branchSales = Branch::withSum(['invoices as total_sales' => fn ($q) => $q->where('status', '!=', 'cancelled')], 'grand_total')->get();
        $staffSales = User::whereIn('role', ['salesperson', 'manager', 'admin'])
            ->withSum(['salesInvoices as total_sales' => fn ($q) => $q->where('status', '!=', 'cancelled')], 'grand_total')
            ->orderByDesc('total_sales')
            ->take(5)
            ->get();

        // Metal price movement (7 days)
        $rateHistory = MetalRate::where('metal_type', 'Gold')
            ->where('purity', '24K')
            ->where('status', 'approved')
            ->orderBy('effective_at')
            ->take(10)
            ->get();

        $pendingApprovals = ApprovalRequest::where('status', 'pending')->count();
        $lowConsumables = Consumable::whereColumn('quantity', '<=', 'reorder_level')->count();
        $recentInvoices = (clone $invoiceQuery)->with(['customer', 'branch'])->latest('billed_at')->take(6)->get();
        $branches = Branch::where('is_active', true)->get();

        return view('dashboard', compact(
            'branches', 'branchId', 'todaySales', 'totalSales', 'outstandingCustomer',
            'metalSales', 'diamondSales', 'goldWeight', 'silverWeight', 'stockValuation',
            'diamondCarats', 'totalPurchaseValue', 'supplierOutstanding', 'pendingOrders',
            'pendingRepairs', 'oldGoldCount', 'oldGoldValue', 'todayProfitEstimate',
            'goldRate24', 'goldRate22', 'silverRate', 'platinumRate',
            'branchSales', 'staffSales', 'rateHistory', 'pendingApprovals',
            'lowConsumables', 'recentInvoices', 'availableItems'
        ));
    }
}

