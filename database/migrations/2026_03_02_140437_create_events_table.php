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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->date('event_date');
            $table->string('location');
            $table->string('category'); // e.g., Road Racing, MTB, BMX
            $table->text('description')->nullable();
            $table->string('status')->default('upcoming'); // upcoming, ongoing, past, cancelled
            $table->string('image')->nullable();
            $table->decimal('registration_fee', 10, 2)->default(0);
            $table->integer('max_participants')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
