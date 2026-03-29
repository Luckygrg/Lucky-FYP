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
        Schema::create('payments', function (Blueprint $table) {
             $table->id();

        // which booking this payment is for
        $table->foreignId('booking_id')->constrained()->onDelete('cascade');

        // which customer paid
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        // amount paid
        $table->decimal('amount', 10, 2);

        // payment method chosen
        $table->enum('method', ['cash', 'esewa']); 

        // payment status
        $table->enum('status', ['pending', 'completed', 'failed'])
          ->default('pending');

        // transaction reference (from payment gateway e.g. eSewa/Khalti)
        $table->string('transaction_id')->unique();

        // when the payment was actually completed
        $table->timestamp('paid_at')->nullable();

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
