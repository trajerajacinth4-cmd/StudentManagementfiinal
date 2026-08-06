<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'semester_id', 'status', 'notes'];

    public static array $statuses = ['Enrolled', 'Dropped', 'Completed'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'enrollment_subjects');
    }
}
