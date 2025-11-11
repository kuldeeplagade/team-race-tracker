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
        Schema::create('race_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('race_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_id')->constrained('team_members')->onDelete('cascade');
            $table->foreignId('checkpoint_id')->constrained('race_checkpoints')->onDelete('cascade');
            $table->timestamp('reached_at');
            $table->timestamps();

            // prevent duplicate (race, member, checkpoint)
            $table->unique(['race_id', 'member_id', 'checkpoint_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('race_logs');
    }
};
