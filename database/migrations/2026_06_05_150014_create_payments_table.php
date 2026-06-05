<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agreement_id')->constrained()->cascadeOnDelete();
            $table->string('invoice_number', 50)->unique();
            $table->decimal('amount', 15, 2);
            $table->decimal('platform_fee', 12, 2);
            $table->decimal('total_amount', 15, 2);
            $table->string('gateway', 20)->default('xendit');
            $table->string('gateway_payment_id')->nullable();
            $table->string('gateway_invoice_url')->nullable();
            $table->string('status', 20)->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->unique('agreement_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
