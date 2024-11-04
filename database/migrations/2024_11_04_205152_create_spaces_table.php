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
            $table->id();
            $table->foreignId('institutionId')->constrained('institutions')->onDelete('cascade');
            $table->foreignId('buildingId')->constrained('buildings')->onDelete('cascade');
            $table->integer('floor');
            $table->string('name');
            $table->string('addressDescription')->nullable();
            $table->string('category');
            $table->string('qrCode');
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
