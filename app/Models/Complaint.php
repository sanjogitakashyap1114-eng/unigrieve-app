<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
protected $fillable = [
        'complaint_id', 
        'student_id', // Yeh users table ki ID hogi
        'department_id', 
        'title', 
        'description',
        'evidence', 
        'category', 
        'priority', 
        'status',
        'remarks'
    ];

    /**
     * Relationship: Complaint kis USER ne ki hai.
     */
    public function user()
    {
        // student_id points to id in users table
        return $this->belongsTo(User::class, 'student_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    // public function studentMaster()
    // {
    //     // Replace 'student_master_id' with your actual foreign key column if it is named differently
    //     return $this->belongsTo(StudentMaster::class, 'student_master_id');
    // }
}

