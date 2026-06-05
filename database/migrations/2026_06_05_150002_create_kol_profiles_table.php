<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kol_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('display_name');
            $table->text('bio')->nullable();
            $table->string('category', 100);
            $table->json('sub_categories')->nullable();
            $table->string('location')->nullable();
            $table->string('gender', 10)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->json('languages')->nullable();
            $table->integer('total_followers')->default(0);
            $table->decimal('avg_engagement_rate', 5, 2)->default(0);
            $table->integer('total_campaigns_done')->default(0);
            $table->decimal('total_earned', 15, 2)->default(0);
            $table->decimal('wallet_balance', 15, 2)->default(0);
            $table->decimal('pending_balance', 15, 2)->default(0);
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->integer('rating_count')->default(0);
            $table->boolean('is_open_for_work')->default(true);
            $table->decimal('min_budget', 12, 2)->nullable();
            $table->timestamp('profile_completed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kol_profiles');
    }
};
