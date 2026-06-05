<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agreement_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kol_profile_id')->constrained()->cascadeOnDelete();
            $table->foreignId('brand_profile_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('caption')->nullable();
            $table->json('media_files')->nullable();
            $table->text('notes')->nullable();
            $table->string('status', 20)->default('draft');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('deadline_at')->nullable();
            $table->string('post_url', 500)->nullable();
            $table->timestamp('posted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contents');
    }
};
