<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'student_id',
        'enrollment_id',
        'grade',
    ];

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function subject()
    {
        return $this->hasOneThrough(
            Subject::class,
            Enrollment::class,
            'id', // Foreign key on enrollments table
            'id', // Foreign key on subjects table
            'enrollment_id', // Local key on grades table
            'subject_id' // Local key on enrollments table
        );
    }

}