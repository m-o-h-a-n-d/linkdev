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
        Schema::create('group_standings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('competition_groups')->cascadeOnDelete();
            $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();
            $table->smallInteger('played')->default(0);
            $table->smallInteger('won')->default(0);
            $table->smallInteger('draw')->default(0);
            $table->smallInteger('lost')->default(0);
            $table->smallInteger('goals_for')->default(0);
            $table->smallInteger('goals_against')->default(0);
            $table->smallInteger('goal_difference')->default(0);
            $table->smallInteger('points')->default(0);
            $table->smallInteger('position_rank');
            $table->timestamps();
            $table->unique(['group_id', 'team_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_standings');
    }
};
