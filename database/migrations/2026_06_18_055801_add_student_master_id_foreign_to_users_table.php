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
        Schema::table('users', function (Blueprint $table) {
            // 1. Ensure the column is explicitly configured as an Unsigned BigInteger first
            $table->unsignedBigInteger('student_master_id')->nullable()->change();

            // 2. Safely apply the physical foreign key constraint mapping
            $table->foreign('student_master_id')
                  ->references('id')
                  ->on('student_masters')
                  ->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drops the foreign key if you ever roll back
            $table->dropForeign(['student_master_id']);
        });
    }
};