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
        Schema::create('service_product_appointment_slot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_product_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointmentslot_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_product_appointment_slot');
    }
};
