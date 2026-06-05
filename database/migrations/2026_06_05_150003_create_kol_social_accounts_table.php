<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kol_social_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kol_profile_id')->constrained()->cascadeOnDelete();
            $table->string('platform', 50);
            $table->string('username');
            $table->string('profile_url', 500);
            $table->integer('followers_count')->default(0);
            $table->integer('following_count')->nullable();
            $table->decimal('engagement_rate', 5, 2)->nullable();
            $table->integer('avg_likes')->nullable();
            $table->integer('avg_comments')->nullable();
            $table->integer('avg_views')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_primary')->default(false);
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kol_social_accounts');
    }
};
