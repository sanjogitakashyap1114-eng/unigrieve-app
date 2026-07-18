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
        Schema::create('student_masters', function (Blueprint $table) {
           $table->id();

            $table->string('registration_no')->unique();

            $table->string('name');

            $table->string('father_name')->nullable();

            $table->enum('gender', ['male', 'female'])->nullable();

            $table->date('date_of_birth')->nullable();

            $table->string('email')->nullable();

            $table->string('phone', 15)->nullable();

            $table->text('address')->nullable();

            $table->string('department');

            $table->string('course');

            $table->string('batch');

            $table->string('semester');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_masters');
    }
};
