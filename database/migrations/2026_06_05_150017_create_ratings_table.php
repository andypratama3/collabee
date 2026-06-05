<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hiring_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rater_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('rated_id')->constrained('users')->cascadeOnDelete();
            $table->string('type', 10);
            $table->tinyInteger('communication')->default(0);
            $table->tinyInteger('professionalism')->default(0);
            $table->tinyInteger('quality')->default(0);
            $table->tinyInteger('timeliness')->default(0);
            $table->decimal('overall', 3, 2)->default(0);
            $table->text('review')->nullable();
            $table->timestamps();

            $table->unique(['hiring_id', 'rater_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
