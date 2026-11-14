<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('metal_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->string('metal_type', 30); // Gold, Silver, Platinum
            $table->string('purity', 20); // 24K, 22K, 20K, 18K, 14K, 9K, 999, 925, 950
            $table->decimal('rate_per_gram', 12, 2);
            $table->timestamp('effective_at');
            $table->string('status', 20)->default('approved'); // approved, pending, rejected
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('notes')->nullable();
            $table->timestamps();
            $table->index(['metal_type', 'purity', 'effective_at']);
        });

        Schema::create('diamond_rate_configs', function (Blueprint $table) {
            $table->id();
            $table->string('shape', 40);
            $table->string('cut', 40);
            $table->string('color', 20);
            $table->string('clarity', 20);
            $table->decimal('rate_per_carat', 12, 2);
            $table->timestamps();
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code', 20)->unique();
            $table->string('default_making_charge_type', 20)->default('per_gram'); // per_gram, percentage, fixed
            $table->decimal('default_making_charge_value', 12, 2)->default(600);
            $table->decimal('default_wastage_pct', 5, 2)->default(0);
            $table->decimal('gst_rate', 5, 2)->default(3.00);
            $table->timestamps();
        });

        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30)->unique();
            $table->string('name');
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('gstin', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('category', 40)->default('manufacturer'); // gold_supplier, silver_supplier, diamond_supplier, manufacturer
            $table->integer('credit_days')->default(30);
            $table->decimal('credit_limit', 14, 2)->default(0);
            $table->decimal('opening_balance', 14, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 40)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subcategory_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_type', 50); // Ring, Necklace, Chain, Bracelet, Earrings, Bangles, Pendant, Coins
            $table->string('metal_type', 30); // Gold, Silver, Platinum
            $table->string('purity', 20); // 24K, 22K, 20K, 18K, 14K, 9K, 999, 925, 950
            $table->string('making_charge_type', 20)->default('per_gram'); // per_gram, percentage, fixed
            $table->decimal('making_charge_value', 12, 2)->default(0);
            $table->decimal('wastage_pct', 5, 2)->default(0);
            $table->decimal('gst_rate', 5, 2)->default(3.00);
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->string('image_path')->nullable();
            $table->string('status', 20)->default('active');
            $table->timestamps();
        });

        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_code', 50)->unique();
            $table->string('barcode', 60)->unique();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('counter_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('gross_weight', 10, 3)->default(0);
            $table->decimal('stone_weight', 10, 3)->default(0);
            $table->decimal('diamond_weight', 10, 3)->default(0); // in carats
            $table->decimal('net_weight', 10, 3)->default(0);
            $table->string('purity', 20);
            $table->string('huid', 30)->nullable()->unique();
            $table->string('hallmark_center')->nullable();
            $table->date('hallmark_date')->nullable();
            $table->decimal('hallmark_charge', 10, 2)->default(45);
            $table->decimal('purchase_cost', 14, 2)->default(0);
            $table->decimal('stone_charge', 12, 2)->default(0);
            $table->decimal('diamond_charge', 12, 2)->default(0);
            $table->decimal('other_charge', 12, 2)->default(0);
            $table->string('status', 30)->default('available'); // available, reserved, sold, damaged, lost, in_transfer, repair
            $table->timestamp('verified_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['branch_id', 'status']);
        });

        Schema::create('stock_transfers', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_no', 40)->unique();
            $table->foreignId('from_branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('to_branch_id')->constrained('branches')->cascadeOnDelete();
            $table->foreignId('from_counter_id')->nullable()->constrained('counters')->nullOnDelete();
            $table->foreignId('to_counter_id')->nullable()->constrained('counters')->nullOnDelete();
            $table->foreignId('initiated_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status', 20)->default('pending'); // pending, approved, completed, rejected
            $table->text('notes')->nullable();
            $table->timestamp('transferred_at')->nullable();
            $table->timestamps();
        });

        Schema::create('stock_transfer_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_transfer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('inventory_item_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->id();
            $table->string('adjustment_no', 40)->unique();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('inventory_item_id')->constrained()->cascadeOnDelete();
            $table->string('type', 30); // damaged, lost, found, weight_correction, verification
            $table->decimal('previous_weight', 10, 3)->nullable();
            $table->decimal('new_weight', 10, 3)->nullable();
            $table->string('reason');
            $table->string('status', 20)->default('pending');
            $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->string('type', 40); // stock_in, sale, transfer_out, transfer_in, adjustment, return_in, hallmark_dispatch, hallmark_receipt
            $table->string('reference', 80)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('diamond_stones', function (Blueprint $table) {
            $table->id();
            $table->string('stone_code', 40)->unique();
            $table->string('stone_type', 30)->default('Diamond'); // Diamond, Ruby, Emerald, Sapphire, Other
            $table->string('shape', 30)->nullable();
            $table->string('cut', 30)->nullable();
            $table->string('color', 20)->nullable();
            $table->string('clarity', 20)->nullable();
            $table->decimal('carat_weight', 10, 3);
            $table->string('certificate_no', 60)->nullable();
            $table->string('certification_lab', 40)->nullable();
            $table->string('certificate_file')->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('inventory_item_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('cost_price', 12, 2)->default(0);
            $table->decimal('selling_price', 12, 2)->default(0);
            $table->decimal('setting_charge', 10, 2)->default(0);
            $table->string('status', 20)->default('in_stock'); // in_stock, set_in_jewellery, sold
            $table->timestamps();
        });

        Schema::create('hallmark_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_item_id')->constrained()->cascadeOnDelete();
            $table->string('center_name');
            $table->date('dispatch_date');
            $table->date('receipt_date')->nullable();
            $table->string('huid', 30)->nullable();
            $table->string('purity_verified', 20)->nullable();
            $table->decimal('charges', 10, 2)->default(45);
            $table->string('status', 30)->default('dispatched'); // dispatched, received, verified
            $table->string('document_path')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('consumables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->string('sku', 40)->unique();
            $table->string('name');
            $table->integer('quantity')->default(0);
            $table->integer('reorder_level')->default(10);
            $table->string('unit', 20)->default('pcs');
            $table->timestamps();
        });

        Schema::create('label_print_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_item_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('label_type', 20)->default('barcode'); // barcode, qr, tag
            $table->integer('copies')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('label_print_logs');
        Schema::dropIfExists('consumables');
        Schema::dropIfExists('hallmark_records');
        Schema::dropIfExists('diamond_stones');
        Schema::dropIfExists('stock_movements');
        Schema::dropIfExists('stock_adjustments');
        Schema::dropIfExists('stock_transfer_items');
        Schema::dropIfExists('stock_transfers');
        Schema::dropIfExists('inventory_items');
        Schema::dropIfExists('products');
        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('subcategories');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('diamond_rate_configs');
        Schema::dropIfExists('metal_rates');
    }
};

