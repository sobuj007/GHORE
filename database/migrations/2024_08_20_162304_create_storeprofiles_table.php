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
        Schema::create('storeprofiles', function (Blueprint $table) {
            $table->id();
            $table->string('storename');
            $table->string('coverImage')->nullable();
            $table->string('servicestime')->nullable();
            $table->string('tradelicence')->nullable();
            $table->string('address');
            $table->string('mobile', 15);
            $table->string('logo')->nullable();
            $table->foreignId('city_id')->constrained()->onDelete('cascade');
            $table->json('location_ids')->nullable(); // JSON field to store multiple locations
            $table->string('nid')->nullable();
            $table->string('company_type');
            $table->foreignId('agent_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storeprofiles');
    }
};
