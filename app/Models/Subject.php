<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    /** @use HasFactory<\Database\Factories\SubjectFactory> */
    use HasFactory;

    protected $fillable = [
        'subject_name',
        'subject_code', // Add subject code
        "year",
        'course', // Add course
    ];


    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
    public function grades()
    {
        return $this->hasMany(Grade::class, 'subject_id');
    }
    


    
}
