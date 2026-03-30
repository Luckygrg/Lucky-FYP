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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            // the customer who wrote the review
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // the spa being reviewed
            $table->foreignId('spa_id')->constrained()->onDelete('cascade');

            // the completed booking that proves the customer used the spa
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');

            // rating from 1 to 5
            $table->tinyInteger('rating')->unsigned();

            // optional written review
            $table->text('comment')->nullable();

            $table->timestamps();

            // one review per booking
            $table->unique('booking_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
