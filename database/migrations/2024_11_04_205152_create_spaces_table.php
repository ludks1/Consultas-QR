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
            $table->enum('type', [
                    SpaceType::COURT->value,
                    SpaceType::AUDITORIUM->value,
                    SpaceType::CAFETERIA->value,
                    SpaceType::CLASSROOM->value,
                    SpaceType::LIBRARY->value,
                    SpaceType::LABORATORY->value,
                    SpaceType::OFFICE->value,
                    SpaceType::PARKING_LOT->value,
                    SpaceType::PRINCIPAL_ROOM->value,
                    SpaceType::VICE_PRINCIPAL_ROOM->value,
                    SpaceType::SERVER_ROOM->value,
                    SpaceType::RESTROOM->value,
                    SpaceType::NURSE_ROOM->value,
                    SpaceType::SECURITY_ROOM->value
                ]
            )->default(SpaceType::CLASSROOM->value);
            $table->text('qrCode')->nullable(false);
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
