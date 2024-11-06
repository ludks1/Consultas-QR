<?php

use App\Enums\SpaceType;
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
            $table->string('type', [
                SpaceType::COURT, SpaceType::AUDITORIUM, SpaceType::CAFETERIA, SpaceType::CLASSROOM,
                    SpaceType::LIBRARY, SpaceType::LABORATORY, SpaceType::OFFICE, SpaceType::PARKING_LOT,
                    SpaceType::PRINCIPAL_ROOM, SpaceType::VICE_PRINCIPAL_ROOM, SpaceType::SERVER_ROOM,
                    SpaceType::RESTROOM, SpaceType::NURSE_ROOM, SpaceType::SECURITY_ROOM
                ]
            )->nullable(false);
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
