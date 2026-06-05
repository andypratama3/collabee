<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agreements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hiring_id')->constrained()->cascadeOnDelete();
            $table->string('agreement_number', 50)->unique();
            $table->decimal('total_amount', 15, 2);
            $table->decimal('platform_fee_percent', 5, 2)->default(5.00);
            $table->text('terms')->nullable();
            $table->string('status', 20)->default('pending');
            $table->timestamp('brand_signed_at')->nullable();
            $table->string('brand_signed_ip', 45)->nullable();
            $table->timestamp('kol_signed_at')->nullable();
            $table->string('kol_signed_ip', 45)->nullable();
            $table->timestamp('signed_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->string('pdf_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agreements');
    }
};
