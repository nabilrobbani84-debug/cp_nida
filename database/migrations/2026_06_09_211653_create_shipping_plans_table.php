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
        Schema::create('shipping_plans', function (Blueprint $table) {
            $table->id();
            $table->string('po_number')->unique();
            $table->date('shipping_date');
            $table->string('status')->default('waiting_invoice'); // waiting_invoice, waiting_packing_list, ready_for_booking, booked
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_plans');
    }
};
