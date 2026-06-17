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
        Schema::create('vessel_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipping_plan_id')->constrained('shipping_plans')->onDelete('cascade');
            $table->string('booking_number')->unique();
            $table->date('booking_date');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vessel_bookings');
    }
};
