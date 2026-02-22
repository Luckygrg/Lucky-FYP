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
        Schema::create('spas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('location');
            $table->string('city');
            $table->text('description');
            $table->string('image')->nullable();
            $table->string('price_range')->default('$$$'); // $, $$, $$$, $$$$
            $table->boolean('is_featured')->default(false);
            $table->decimal('rating', 2, 1)->default(0.0);
            $table->integer('review_count')->default(0);
            $table->json('tags')->nullable(); // e.g., ["Massage", "Facial", "Yoga"]
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('opening_hours')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spas');
    }
};
