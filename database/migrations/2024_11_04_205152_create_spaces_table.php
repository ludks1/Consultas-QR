<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('spaces', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('buildingId')->constrained('buildings')->onDelete('cascade');
            $table->integer('floor')->default(1);
            $table->string('name')->nullable(false);
            $table->string('addressDescription')->nullable();
            $table->string('type')->nullable(false);
            $table->integer('qrCode')->nullable(false);
            $table->integer('capacity')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spaces');
    }
};
