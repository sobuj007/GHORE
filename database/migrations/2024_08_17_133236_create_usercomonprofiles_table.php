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
        Schema::create('usercomonprofiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('img')->nullable();
            $table->string('address')->nullable();
            $table->string('mobilenumber')->nullable();
              $table->enum('gender', ['male', 'female']);

            $table->timestamps();

            // Foreign key constraint, assuming 'users' table exists
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usercomonprofiles');
    }
};
