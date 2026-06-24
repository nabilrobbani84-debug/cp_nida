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
        Schema::create('export_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('export_invoice_id')->constrained('export_invoices')->onDelete('cascade');
            $table->string('po_no');
            $table->date('po_dated');
            $table->integer('quantity');
            $table->text('description');
            $table->double('basic_price');
            $table->double('material_surcharge')->default(0);
            $table->double('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('export_invoice_items');
    }
};
