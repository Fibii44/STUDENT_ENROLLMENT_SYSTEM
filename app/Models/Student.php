<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'age',
        'year',
        'course',
        'address',
    ];
    
    
    public function enrollments()
{
    return $this->hasMany(Enrollment::class);
}
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'enrollments'); // Adjust 'enrollments' if your pivot table has a different name
    }

}
