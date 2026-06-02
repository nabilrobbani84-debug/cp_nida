<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id_product');
            $table->string('code')->unique();
            $table->string('name');
            $table->unsignedBigInteger('id_product_type');
            $table->unsignedBigInteger('id_unit');
            $table->string('hs_code')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_product_type')
                ->references('id_product_type')
                ->on('product_types')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('id_unit')
                ->references('id_unit')
                ->on('units')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};