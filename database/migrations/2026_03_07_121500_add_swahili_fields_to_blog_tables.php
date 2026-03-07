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
        Schema::table('blog_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('blog_categories', 'name_sw')) {
                $table->string('name_sw')->nullable()->after('name');
            }
        });

        Schema::table('blog_sub_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('blog_sub_categories', 'name_sw')) {
                $table->string('name_sw')->nullable()->after('name');
            }
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            if (!Schema::hasColumn('blog_posts', 'title_sw')) {
                $table->string('title_sw')->nullable()->after('title');
            }
            if (!Schema::hasColumn('blog_posts', 'summary_sw')) {
                $table->text('summary_sw')->nullable()->after('summary');
            }
            if (!Schema::hasColumn('blog_posts', 'content_sw')) {
                $table->longText('content_sw')->nullable()->after('content');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blog_categories', function (Blueprint $table) {
            if (Schema::hasColumn('blog_categories', 'name_sw')) {
                $table->dropColumn('name_sw');
            }
        });

        Schema::table('blog_sub_categories', function (Blueprint $table) {
            if (Schema::hasColumn('blog_sub_categories', 'name_sw')) {
                $table->dropColumn('name_sw');
            }
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $cols = [];
            if (Schema::hasColumn('blog_posts', 'title_sw')) {
                $cols[] = 'title_sw';
            }
            if (Schema::hasColumn('blog_posts', 'summary_sw')) {
                $cols[] = 'summary_sw';
            }
            if (Schema::hasColumn('blog_posts', 'content_sw')) {
                $cols[] = 'content_sw';
            }
            if (!empty($cols)) {
                $table->dropColumn($cols);
            }
        });
    }
};
