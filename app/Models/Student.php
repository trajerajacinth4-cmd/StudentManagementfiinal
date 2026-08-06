<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_number',
        'first_name',
        'middle_name',
        'last_name',
        'name',
        'email',
        'course',
        'year_level',
        'status',
        'gpa',
        'avatar',
        'age',
    ];

    /**
     * Get Combined Full Name (First [Middle] Last).
     */
    public function getNameAttribute($value): string
    {
        if (!empty($this->attributes['first_name']) || !empty($this->attributes['last_name'])) {
            $parts = array_filter([
                $this->attributes['first_name'] ?? '',
                $this->attributes['middle_name'] ?? '',
                $this->attributes['last_name'] ?? '',
            ]);
            return implode(' ', $parts);
        }

        return $value ?? 'N/A';
    }

    /**
     * Get Student Avatar URL or return UI Avatar default fallback.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/' . $this->avatar);
        }

        $name = urlencode($this->name);
        return "https://ui-avatars.com/api/?name={$name}&background=4f46e5&color=fff&size=128&font-size=0.4";
    }

    /**
     * Standard list of allowed student statuses.
     */
    public static array $statuses = ['Active', 'Graduated', 'Dropped', 'On Leave'];

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}
