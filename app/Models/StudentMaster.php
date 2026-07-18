<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentMaster extends Model
{
    protected $fillable = [
    'registration_no',
    'name',
    'father_name',
    'gender',
    'date_of_birth',
    'email',
    'phone',
    'address',
    'department',
    'course',
    'batch',
    'semester',
];
// public function studentMaster()
// {
//     // belongsTo(ModelName, 'current_table_foreign_key', 'parent_table_primary_key')
//     return $this->belongsTo(StudentMaster::class, 'student_master_id', 'id');
// }
}
