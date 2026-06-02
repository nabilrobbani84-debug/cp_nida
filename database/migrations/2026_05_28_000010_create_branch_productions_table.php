<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branch_productions', function (Blueprint $table) {
            $table->id();
            $table->date('production_date');
            $table->unsignedBigInteger('id_branch');
            $table->unsignedBigInteger('id_product');
            $table->unsignedInteger('good_products')->default(0);
            $table->unsignedInteger('rejected_products')->default(0);
            $table->string('status')->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_branch')
                ->references('id_branch')
                ->on('branches')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('id_product')
                ->references('id_product')
                ->on('products')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branch_productions');
    }
};
