<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hiring_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kol_profile_id')->constrained()->cascadeOnDelete();
            $table->decimal('proposed_budget', 12, 2)->nullable();
            $table->text('message')->nullable();
            $table->string('status', 20)->default('pending');
            $table->timestamps();

            $table->unique(['campaign_id', 'kol_profile_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hiring_applications');
    }
};
