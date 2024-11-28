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
        Schema::create('orders_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('service_product_id');
            $table->integer('product_quantity');
            $table->integer('service_quantity');
            $table->decimal('product_price', 8, 2);
            $table->decimal('service_price', 8, 2);
                   $table->string('userreqtime');
                   $table->string('	req_order_date')->nullable();
                   $table->string('status')->default('pending');
                   $table->string('status')->default('pending');
            $table->string('payable')->nullable();
            $table->foreign('service_product_id')->references('id')->on('service_products')->onDelete('cascade');
            $table->timestamps();    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_items');
    }
};
