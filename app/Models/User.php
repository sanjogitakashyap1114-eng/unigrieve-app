<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name','email', 'student_master_id','role','password','department_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function studentMaster()
{
    return $this->belongsTo(StudentMaster::class, 'student_master_id');
}


public function complaints()
{
    return $this->hasMany(Complaint::class, 'student_id');
}

public function serviceRequests()
{
    return $this->hasMany(ServiceRequest::class, 'student_id');
}
public function department()
{
    return $this->belongsTo(Department::class, 'department_id');
}
}
