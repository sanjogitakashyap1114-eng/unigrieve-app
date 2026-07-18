<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
   protected $fillable = [
    'name',
    'description',
    'head_name',
    'email',
    'phone',
];
public function staff()
    {
        // This maps to the 'department_id' column inside your users table
        return $this->hasMany(User::class, 'department_id'); 
    }

    /**
     * Relationship: A department has many complaints routed to it
     */
    public function complaints()
    {
        // This maps to the 'department_id' column inside your complaints table
        return $this->hasMany(Complaint::class, 'department_id');
    }
}
