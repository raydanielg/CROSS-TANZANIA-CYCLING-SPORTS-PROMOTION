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
        Schema::create('gallery_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_category_id')->constrained('gallery_categories')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->string('title_sw')->nullable();
            $table->string('file_path');
            $table->string('filename');
            $table->string('alt_text')->nullable();
            $table->integer('file_size')->comment('in bytes');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['gallery_category_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gallery_images');
    }
};
