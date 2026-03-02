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
        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'start_location')) {
                $table->string('start_location')->nullable()->after('location');
            }
            if (!Schema::hasColumn('events', 'end_location')) {
                $table->string('end_location')->nullable()->after('start_location');
            }
            if (!Schema::hasColumn('events', 'distance_km')) {
                $table->decimal('distance_km', 8, 2)->nullable()->after('end_location');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $to_drop = [];
            if (Schema::hasColumn('events', 'start_location')) {
                $to_drop[] = 'start_location';
            }
            if (Schema::hasColumn('events', 'end_location')) {
                $to_drop[] = 'end_location';
            }
            if (Schema::hasColumn('events', 'distance_km')) {
                $to_drop[] = 'distance_km';
            }

            if (!empty($to_drop)) {
                $table->dropColumn($to_drop);
            }
        });
    }
};
