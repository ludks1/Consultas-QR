<?php

use App\Enums\Career;
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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name')->nullable(false);
            $table->integer('code')->autoIncrement();
            $table->text('description')->nullable();
            $table->string('career', [
                    Career::ISW->value, Career::IPI->value, Career::ITC->value
                ]
            )->default(Career::ISW->value);
            $table->integer('semester')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
