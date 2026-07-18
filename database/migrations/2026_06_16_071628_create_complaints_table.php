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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->string('complaint_id', 30); // Eg: COMP-2026-0001
    
    // YEH RAHI APKI USER FOREIGN KEY
    // Yeh users table ki 'id' ko point karegi, kyunki wahi login user hai
    $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
    
    $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
    $table->string('title', 255);
    $table->text('description');
    $table->enum('category', ['Academic', 'Hostel', 'Fees', 'Administration', 'Safety', 'Others']);
    $table->enum('priority', ['High', 'Medium', 'Low'])->default('Medium');
    $table->enum('status', ['Pending', 'In Progress', 'Resolved', 'Rejected'])->default('Pending');
    $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
