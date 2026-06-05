<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hirings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
            $table->foreignId('brand_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kol_profile_id')->constrained()->cascadeOnDelete();
            $table->string('initiated_by', 10);
            $table->string('status', 20)->default('pending');
            $table->text('message')->nullable();
            $table->decimal('proposed_budget', 12, 2)->nullable();
            $table->decimal('agreed_budget', 12, 2)->nullable();
            $table->text('note')->nullable();
            $table->text('rejected_reason')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index(['campaign_id', 'kol_profile_id'])->unique();
            $table->index('kol_profile_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hirings');
    }
};
