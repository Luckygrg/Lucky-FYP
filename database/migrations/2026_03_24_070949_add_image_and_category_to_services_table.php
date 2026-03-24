<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->foreignId('spa_category_id')->nullable()->constrained('spa_categories')->nullOnDelete()->after('is_available');
            $table->string('image')->nullable()->after('spa_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropForeign(['spa_category_id']);
            $table->dropColumn(['spa_category_id', 'image']);
        });
    }
};
