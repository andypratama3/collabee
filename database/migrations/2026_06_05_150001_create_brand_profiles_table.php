<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brand_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('brand_name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('industry', 100);
            $table->string('website')->nullable();
            $table->json('target_market')->nullable();
            $table->string('location')->nullable();
            $table->string('logo')->nullable();
            $table->string('banner')->nullable();
            $table->integer('total_campaigns')->default(0);
            $table->decimal('total_spent', 15, 2)->default(0);
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->integer('rating_count')->default(0);
            $table->timestamp('profile_completed_at')->nullable();
            $table->timestamps();

            $table->index('industry');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brand_profiles');
    }
};
