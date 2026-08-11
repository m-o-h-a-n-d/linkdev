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
        Schema::table('teams', function (Blueprint $table) {
            $table->string('email')->nullable()->after('country');
            $table->string('phone')->nullable()->after('email');
            $table->string('manager_name')->nullable()->after('phone');
            $table->string('arena')->nullable()->after('manager_name');
            $table->string('status')->default('pending')->after('arena');
            $table->text('rejection_reason')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn([
                'email',
                'phone',
                'manager_name',
                'arena',
                'status',
                'rejection_reason',
            ]);
        });
    }
};
