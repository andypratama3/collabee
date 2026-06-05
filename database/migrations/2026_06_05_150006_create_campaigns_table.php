<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_profile_id')->constrained()->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('title', 500);
            $table->longText('description');
            $table->longText('brief')->nullable();
            $table->json('objectives')->nullable();
            $table->json('platforms');
            $table->json('content_types');
            $table->string('kol_category', 100)->nullable();
            $table->integer('min_followers')->nullable();
            $table->integer('max_followers')->nullable();
            $table->decimal('min_engagement', 5, 2)->nullable();
            $table->string('target_gender', 10)->default('all');
            $table->string('location')->nullable();
            $table->decimal('budget_total', 15, 2);
            $table->decimal('budget_per_kol', 12, 2)->nullable();
            $table->integer('kol_slots')->default(1);
            $table->integer('kol_filled')->default(0);
            $table->date('start_date');
            $table->date('end_date');
            $table->date('deadline_apply');
            $table->string('status', 20)->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->integer('views_count')->default(0);
            $table->integer('applications_count')->default(0);
            $table->timestamps();

            $table->index(['brand_profile_id', 'status']);
            $table->index(['status', 'deadline_apply']);
            $table->index(['kol_category', 'min_followers']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
