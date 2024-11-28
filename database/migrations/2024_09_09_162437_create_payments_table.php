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
            $table->unsignedBigInteger('order_id');
            $table->decimal('amount', 8, 2);
            $table->string('status')->default('pending');
            $table->string('trans_type')->default('Cash on Delivery');
            $table->string('address');
            $table->string('notes')->nullable();
            $table->string('mobile');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders_news')->onDelete('cascade');
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
