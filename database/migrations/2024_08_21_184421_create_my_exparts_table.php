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
        Schema::create('my_exparts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('profile_image');
            $table->integer('expartyear');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('mobile');
            $table->json('certificate_images')->nullable();
            $table->foreignId('agent_id')->constrained('users')->onDelete('cascade'); // Change 'agents' to 'users'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_exparts');
    }
};
