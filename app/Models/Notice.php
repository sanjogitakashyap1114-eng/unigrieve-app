<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
        'department_id',
        'title',
        'description',
        'last_date',
        'attachment',
        'is_active'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
