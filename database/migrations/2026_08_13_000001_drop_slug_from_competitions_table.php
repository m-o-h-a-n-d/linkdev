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
        if (! Schema::hasColumn('competitions', 'slug')) {
            return;
        }

        Schema::table('competitions', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('competitions', 'slug')) {
            return;
        }

        Schema::table('competitions', function (Blueprint $table) {
            $table->string('slug', 255)->unique()->after('name');
        });
    }
};
