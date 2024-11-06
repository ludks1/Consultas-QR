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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('spaceId')->constrained('spaces');
            $table->string('name')->nullable(false);
            $table->string('description')->nullable();
            $table->date('startDate')->default('2024-11-04');
            $table->date('endDate')->default('2024-11-04');
            $table->time('startTime')->default('07:00:00');
            $table->time('endTime')->default('20:00:00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
