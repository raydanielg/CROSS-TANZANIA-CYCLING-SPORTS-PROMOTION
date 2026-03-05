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
        Schema::table('content_pages', function (Blueprint $table) {
            $table->string('title_sw')->nullable()->after('title');
            $table->string('subtitle_sw')->nullable()->after('subtitle');
            $table->text('content_sw')->nullable()->after('content');
            $table->json('sections_sw')->nullable()->after('sections');
        });

        Schema::table('deals', function (Blueprint $table) {
            $table->string('title_sw')->nullable()->after('title');
            $table->string('subtitle_sw')->nullable()->after('subtitle');
            $table->text('description_sw')->nullable()->after('description');
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('role_sw')->nullable()->after('role');
            $table->text('content_sw')->nullable()->after('content');
        });

        Schema::table('support_faqs', function (Blueprint $table) {
            $table->string('question_sw')->nullable()->after('question');
            $table->text('answer_sw')->nullable()->after('answer');
        });
    }

    public function down(): void
    {
        Schema::table('content_pages', function (Blueprint $table) {
            $table->dropColumn(['title_sw', 'subtitle_sw', 'content_sw', 'sections_sw']);
        });

        Schema::table('deals', function (Blueprint $table) {
            $table->dropColumn(['title_sw', 'subtitle_sw', 'description_sw']);
        });

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['role_sw', 'content_sw']);
        });

        Schema::table('support_faqs', function (Blueprint $table) {
            $table->dropColumn(['question_sw', 'answer_sw']);
        });
    }
};
