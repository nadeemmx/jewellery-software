<?php

use App\Models\MetalRate;
use App\Services\JewelleryPriceCalculator;
use App\Services\LiveMetalRateService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('rates:sync {--city=guwahati : City for live Indian retail gold rates} {--branch= : Optional branch ID to update}', function () {
    $this->info('Fetching live Indian domestic bullion market prices...');

    try {
        $city = (string) ($this->option('city') ?: 'guwahati');
        $branchId = $this->option('branch') ?: null;

        $result = LiveMetalRateService::sync($city, $branchId);

        $this->info("Successfully published live rates for {$result['city']} ({$result['source']}):");
        $this->line(" - 24K Gold: Rs {$result['gold_24k']}/g");
        $this->line(" - 22K Gold: Rs {$result['gold_22k']}/g");
        $this->line(" - Silver 999: Rs {$result['silver_999']}/g");

        return 0;
    } catch (\Throwable $e) {
        $this->error('Failed to sync live rates: ' . $e->getMessage());
        return 1;
    }
})->purpose('Fetch and update live metal rates from bullion market feed');

// Automatically run daily at 9:30 AM (bullion market opening)
Schedule::command('rates:sync')->dailyAt('09:30');
