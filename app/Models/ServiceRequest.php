<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;

    // Table ka naam batayein
    protected $table = 'service_requests';

    // Kaun-kaun se fields mass-assignable hain (Fillable Array)
    protected $fillable = [
        'service_id',
        'student_id',
        'department_id',
        'service_type',
        'additional_details', // 🌟 JSON column
        'description',
        'evidence',
        'status',
        'remarks'
    ];

    /**
     * 🌟 SABSE ZAROORI PART: Casts
     * Yeh Laravel ko batata hai ki jab bhi 'additional_details' database se aaye, 
     * toh use direct PHP Array bana de taaki hum Blade view me asaani se print kar sakein.
     */
    protected $casts = [
        'additional_details' => 'array',
    ];

    // ==================== RELATIONSHIPS ====================

    // Yeh service request kis student ki hai
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Yeh service request kis department ke paas gayi hai
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}