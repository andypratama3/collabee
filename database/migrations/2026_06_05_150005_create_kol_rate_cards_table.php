<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kol_rate_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kol_profile_id')->constrained()->cascadeOnDelete();
            $table->string('platform', 50);
            $table->string('content_type', 50);
            $table->decimal('price', 12, 2);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kol_rate_cards');
    }
};
