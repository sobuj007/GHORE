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
        Schema::create('service_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agent_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('subcategory_id')->constrained()->onDelete('cascade');
            $table->foreignId('bodypart_id')->nullable()->constrained('body_parts')->onDelete('set null');
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->json('location_ids'); // Store multiple location IDs as JSON
            $table->foreignId('slot_id')->nullable()->constrained('myslots')->onDelete('set null');
            $table->json('appointment_slot_ids')->nullable(); // Store multiple appointment slot IDs as JSON
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('product_price', 8, 2);
            $table->decimal('service_price', 8, 2);
            $table->enum('gender', ['male', 'female', 'both']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serviceproducts');
    }
};