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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->text('about_us_text')->nullable(); // Stores "About Us" text
            $table->string('phone_number')->nullable(); // Phone number
            $table->string('email')->nullable(); // Contact email
            $table->string('address')->nullable(); // Physical address
            $table->string('logo')->nullable(); // Logo file path
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
