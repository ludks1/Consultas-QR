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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institutionId')->constrained('institutions')->onDelete('cascade');
            $table->foreignId('buildingId')->constrained('buildings')->onDelete('cascade');
            $table->foreignId('spaceId')->constrained('spaces')->onDelete('cascade');
            $table->foreignId('subjectId')->constrained('subjects')->onDelete('cascade');
            $table->string('day');
            $table->time('startIime');
            $table->time('endIime');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
