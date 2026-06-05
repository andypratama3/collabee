<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->string('tracking_code', 20)->nullable()->unique()->after('post_url');
            $table->unsignedInteger('click_count')->default(0)->after('tracking_code');
        });
    }

    public function down(): void
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->dropColumn(['tracking_code', 'click_count']);
        });
    }
};
