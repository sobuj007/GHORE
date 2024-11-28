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
        Schema::create('review_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('serviceproduct_id')->nullable(); // Reference to service_products
            $table->unsignedBigInteger('agent_id')->nullable(); // Reference to users (agent)
            $table->unsignedBigInteger('user_id'); // Reference to users (reviewer)
            $table->string('reviewername');
            $table->string('image')->nullable();
            $table->integer('rating');
            $table->text('comment');
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('serviceproduct_id')->references('id')->on('service_products')->onDelete('cascade');
            $table->foreign('agent_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_ratings');
    }
};
