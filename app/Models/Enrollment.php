<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    /** @use HasFactory<\Database\Factories\EnrollmentFactory> */
    use HasFactory;

    protected $fillable = [
        'student_id',
        'student_name',
        'subject_id',
        'semester',
        'status'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function subject()
{
    return $this->belongsTo(Subject::class);
}

    public function grades()
    {
        return $this->hasMany(Grade::class, 'enrollment_id');
    }




}
