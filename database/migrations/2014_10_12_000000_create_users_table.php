<?php

use App\Enums\UserType;
use App\Enums\Career;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('name')->always();
            $table->string('accountId')->unique();
            $table->string('email')->unique();
            $table->timestamp('emailVerifiedAt')->nullable();
            $table->string('type', [
                    UserType::STUDENT->value, UserType::TEACHER->value
                ]
            )->default(UserType::STUDENT->value);
            $table->string('password')->always();
            $table->string('career', [
                    Career::ISW->value, Career::IPI->value, Career::ITC->value
                ]
            )->default(Career::ISW->value);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
