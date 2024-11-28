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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('service_product_id');
            $table->integer('product_quantity');
            $table->decimal('product_price', 10, 2);
            $table->integer('service_quantity');
            $table->decimal('service_price', 10, 2);
            $table->unsignedBigInteger('selected_slot');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('service_product_id')->references('id')->on('service_products')->onDelete('cascade');
            $table->foreign('selected_slot')->references('id')->on('appointmentslots')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
