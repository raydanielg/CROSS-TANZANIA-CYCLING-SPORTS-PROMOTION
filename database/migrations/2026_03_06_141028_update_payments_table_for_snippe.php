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
        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained()->onDelete('set null');
            $table->string('currency', 3)->default('TZS')->after('amount');
            $table->string('description')->nullable()->after('currency');
            $table->json('metadata')->nullable()->after('description');
            $table->string('checkout_url')->after('reference')->nullable();
            $table->string('webhook_status')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'currency', 'description', 'metadata', 'checkout_url', 'webhook_status']);
        });
    }
};
