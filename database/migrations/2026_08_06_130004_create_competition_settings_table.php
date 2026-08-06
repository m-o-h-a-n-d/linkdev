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
        Schema::create('competition_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition_id')->unique()->constrained('competitions')->cascadeOnDelete();
            $table->enum('competition_type', ['league', 'knockout', 'mixed'])->default('mixed');
            $table->smallInteger('max_teams');
            $table->tinyInteger('points_win')->default(3);
            $table->tinyInteger('points_draw')->default(1);
            $table->tinyInteger('points_loss')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competition_settings');
    }
};
