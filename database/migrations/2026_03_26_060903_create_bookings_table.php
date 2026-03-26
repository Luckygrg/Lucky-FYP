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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            // customer who made the booking
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // which spa the booking belongs to
            $table->foreignId('spa_id')->constrained()->onDelete('cascade');

            // booking date and time
            $table->date('booking_date');
            $table->time('booking_time');

            // total duration and amount
            $table->integer('total_duration_minutes')->default(0);
            $table->decimal('total_price', 10, 2)->default(0.00);

            // booking status
            $table->enum('status', [
                'pending',
                'confirmed',
                'completed',
                'cancelled',
            ])->default('pending');

            // payment status
            $table->enum('payment_status', [
                'unpaid',
                'paid',
            ])->default('unpaid');

            // optional fields
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
