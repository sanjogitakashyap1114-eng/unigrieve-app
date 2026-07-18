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
        Schema::create('service_requests', function (Blueprint $table) {
            $table->id();
            $table->string('service_id', 30)->unique(); 
            
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            
            $table->foreignId('department_id')->constrained('departments')->onDelete('cascade');
            
            $table->enum('service_type', ['Bus Pass', 'Bonafide Certificate', 'ID Card', 'Hostel Room Change', 'WiFi Registration']);
            
            $table->text('description');
            
            // Status Tracking
            $table->enum('status', ['Pending', 'In Progress', 'Resolved', 'Rejected'])->default('Pending');
            
            // Administrative staff remarks
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};
