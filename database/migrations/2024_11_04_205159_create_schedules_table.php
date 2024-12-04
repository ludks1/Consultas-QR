<?php

use App\Enums\Days;
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
            $table->foreignId('spaceId')->constrained('spaces')->onDelete('cascade');
            $table->foreignId('subjectId')->constrained('subjects')->onDelete('cascade');
            $table->enum('day', [
                Days::MONDAY->value,
                Days::TUESDAY->value,
                Days::WEDNESDAY->value,
                Days::THURSDAY->value,
                Days::FRIDAY->value,
                Days::SATURDAY->value,
                Days::SUNDAY->value
            ])->default(Days::MONDAY->value);
            $table->time('startIime')->default('07:00:00');
            $table->time('endIime')->default('20:00:00');
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
