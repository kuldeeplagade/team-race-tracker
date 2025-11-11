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
        Schema::create('race_checkpoints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('race_id')->constrained()->onDelete('cascade');
            $table->string('checkpoint_name');
            $table->unsignedInteger('order_no'); // 1 = start, last = end
            $table->timestamps();

            $table->unique(['race_id', 'order_no']); // order unique per race
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('race_checkpoints');
    }
};
