<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'JewelERP — Complete Jewellery Shop Management')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 antialiased">
<div class="min-h-screen flex">
    <!-- Sidebar -->
    <aside class="no-print w-64 bg-slate-900 text-slate-200 flex-shrink-0 flex flex-col border-r border-slate-800">
        <div class="px-5 py-4 border-b border-slate-800 flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-amber-400 to-yellow-600 flex items-center justify-center text-slate-950 font-bold text-lg shadow">
                ✦
            </div>
            <div>
                <div class="font-bold text-white tracking-tight truncate max-w-[150px]" title="{{ $businessName }}">{{ $businessName }}</div>
                <div class="text-[11px] text-amber-400/90 uppercase tracking-wider truncate max-w-[150px]" title="{{ $businessTagline }}">{{ $businessTagline }}</div>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-5 text-sm">
            <div>
                <div class="px-3 mb-1.5 text-[11px] font-semibold uppercase tracking-wider text-slate-400">Overview</div>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-amber-500/15 text-amber-300 font-medium' : 'hover:bg-slate-800/70' }}">
                    <span>📊</span> Dashboard & Analytics
                </a>
                <a href="{{ route('rates.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg {{ request()->routeIs('rates.*') ? 'bg-amber-500/15 text-amber-300 font-medium' : 'hover:bg-slate-800/70' }}">
                    <span>🪙</span> Metal Rates
                </a>
            </div>

            <div>
                <div class="px-3 mb-1.5 text-[11px] font-semibold uppercase tracking-wider text-slate-400">Billing & Exchange</div>
                <a href="{{ route('pos.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg {{ request()->routeIs('pos.index') ? 'bg-amber-500/15 text-amber-300 font-medium' : 'hover:bg-slate-800/70' }}">
                    <span>🧾</span> Jewellery POS
                </a>
                <a href="{{ route('pos.invoices') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg {{ request()->routeIs('pos.invoices', 'pos.invoice') ? 'bg-amber-500/15 text-amber-300 font-medium' : 'hover:bg-slate-800/70' }}">
                    <span>↩️</span> Invoices & Returns
                </a>
                <a href="{{ route('old_gold.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg {{ request()->routeIs('old_gold.*') ? 'bg-amber-500/15 text-amber-300 font-medium' : 'hover:bg-slate-800/70' }}">
                    <span>⚖️</span> Old Gold Exchange
                </a>
            </div>

            <div>
                <div class="px-3 mb-1.5 text-[11px] font-semibold uppercase tracking-wider text-slate-400">Catalog & Vault</div>
                <a href="{{ route('products.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg {{ request()->routeIs('products.*') ? 'bg-amber-500/15 text-amber-300 font-medium' : 'hover:bg-slate-800/70' }}">
                    <span>💍</span> Product Master
                </a>
                <a href="{{ route('inventory.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg {{ request()->routeIs('inventory.index') ? 'bg-amber-500/15 text-amber-300 font-medium' : 'hover:bg-slate-800/70' }}">
                    <span>📦</span> Inventory & Stock
                </a>
                <a href="{{ route('inventory.labels') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg {{ request()->routeIs('inventory.labels') ? 'bg-amber-500/15 text-amber-300 font-medium' : 'hover:bg-slate-800/70' }}">
                    <span>🏷️</span> Barcode & Tags
                </a>
                <a href="{{ route('stones.hallmark') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg {{ request()->routeIs('stones.hallmark') ? 'bg-amber-500/15 text-amber-300 font-medium' : 'hover:bg-slate-800/70' }}">
                    <span>💎</span> Diamonds & HUID
                </a>
            </div>

            <div>
                <div class="px-3 mb-1.5 text-[11px] font-semibold uppercase tracking-wider text-slate-400">Operations</div>
                <a href="{{ route('crm.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg {{ request()->routeIs('crm.*') ? 'bg-amber-500/15 text-amber-300 font-medium' : 'hover:bg-slate-800/70' }}">
                    <span>👥</span> CRM, Loyalty & Ads
                </a>
                <a href="{{ route('schemes.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg {{ request()->routeIs('schemes.*') ? 'bg-amber-500/15 text-amber-300 font-medium' : 'hover:bg-slate-800/70' }}">
                    <span>🏦</span> Gold Savings Schemes
                </a>
                <a href="{{ route('workshop.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg {{ request()->routeIs('workshop.*') ? 'bg-amber-500/15 text-amber-300 font-medium' : 'hover:bg-slate-800/70' }}">
                    <span>🛠️</span> Karigar, Custom & Repair
                </a>
                <a href="{{ route('purchases.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg {{ request()->routeIs('purchases.*') ? 'bg-amber-500/15 text-amber-300 font-medium' : 'hover:bg-slate-800/70' }}">
                    <span>🚚</span> Suppliers & Purchases
                </a>
            </div>

            <div>
                <div class="px-3 mb-1.5 text-[11px] font-semibold uppercase tracking-wider text-slate-400">Finance & Admin</div>
                <a href="{{ route('finance.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg {{ request()->routeIs('finance.*') ? 'bg-amber-500/15 text-amber-300 font-medium' : 'hover:bg-slate-800/70' }}">
                    <span>📒</span> Accounts & Finance
                </a>
                <a href="{{ route('admin.staff') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg {{ request()->routeIs('admin.staff') ? 'bg-amber-500/15 text-amber-300 font-medium' : 'hover:bg-slate-800/70' }}">
                    <span>🪪</span> Staff & Attendance
                </a>
                <a href="{{ route('admin.branches') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg {{ request()->routeIs('admin.branches') ? 'bg-amber-500/15 text-amber-300 font-medium' : 'hover:bg-slate-800/70' }}">
                    <span>🏢</span> Multi-Branch
                </a>
                <a href="{{ route('admin.security') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg {{ request()->routeIs('admin.security') ? 'bg-amber-500/15 text-amber-300 font-medium' : 'hover:bg-slate-800/70' }}">
                    <span>🔐</span> Approvals & Audit
                </a>
                <a href="{{ route('admin.reports') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg {{ request()->routeIs('admin.reports') ? 'bg-amber-500/15 text-amber-300 font-medium' : 'hover:bg-slate-800/70' }}">
                    <span>📈</span> BI Reports
                </a>
                <a href="{{ route('settings.index') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg {{ request()->routeIs('settings.*') ? 'bg-amber-500/15 text-amber-300 font-medium' : 'hover:bg-slate-800/70' }}">
                    <span>⚙️</span> Showroom Settings
                </a>
            </div>
        </nav>

        <div class="p-4 border-t border-slate-800 text-xs text-slate-400">
            <div class="font-medium text-slate-200">{{ auth()->user()->name }}</div>
            <div class="capitalize">{{ auth()->user()->role }} · {{ auth()->user()->branch->code ?? 'HQ' }}</div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Top Header -->
        <header class="no-print bg-white border-b border-slate-200 px-6 py-3 flex items-center justify-between gap-4">
            <h1 class="text-lg font-semibold text-slate-800">@yield('header', 'Dashboard')</h1>

            <div class="flex items-center gap-4 text-xs">
                <div class="hidden md:flex items-center gap-3 bg-amber-50 border border-amber-200/80 px-3 py-1.5 rounded-full text-amber-900 font-medium">
                    <span>24K: ₹{{ number_format(\App\Models\MetalRate::latestRate('Gold', '24K'), 0) }}/g</span>
                    <span class="text-amber-300">|</span>
                    <span>22K: ₹{{ number_format(\App\Models\MetalRate::latestRate('Gold', '22K'), 0) }}/g</span>
                    <span class="text-amber-300">|</span>
                    <span>Silver: ₹{{ number_format(\App\Models\MetalRate::latestRate('Silver', '999'), 0) }}/g</span>
                </div>
                <a href="{{ route('pos.index') }}" class="bg-amber-600 hover:bg-amber-700 text-white px-3.5 py-1.5 rounded-lg font-medium transition">+ New Bill</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-slate-500 hover:text-slate-800 font-medium px-2 py-1">Logout</button>
                </form>
            </div>
        </header>

        <!-- Alerts -->
        <div class="px-6 pt-4 no-print">
            @if(session('success'))
                <div class="mb-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-2.5 rounded-lg text-sm flex justify-between">
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if($errors->any())
                <div class="mb-3 bg-rose-50 border border-rose-200 text-rose-800 px-4 py-2.5 rounded-lg text-sm">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Page Body -->
        <main class="flex-1 px-6 pb-8 pt-2">
            @yield('content')
        </main>
    </div>
</div>
@stack('scripts')
</body>
</html>

