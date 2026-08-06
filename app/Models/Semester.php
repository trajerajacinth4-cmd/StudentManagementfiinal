<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'school_year', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public static array $semesterNames = ['1st Semester', '2nd Semester', 'Summer'];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * Get display label combining name and school year.
     */
    public function getLabelAttribute(): string
    {
        return "{$this->name} — S.Y. {$this->school_year}";
    }

    /**
     * Activate this semester and deactivate all others.
     */
    public function activate(): void
    {
        self::where('is_active', true)->update(['is_active' => false]);
        $this->update(['is_active' => true]);
    }

    /**
     * Get the currently active semester.
     */
    public static function active(): ?self
    {
        return self::where('is_active', true)->first();
    }
}
