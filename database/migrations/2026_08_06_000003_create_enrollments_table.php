<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('semester_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('Enrolled'); // Enrolled, Dropped, Completed
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'semester_id']);
        });

        Schema::create('enrollment_subjects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('enrollment_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->timestamps();

            $table->unique(['enrollment_id', 'subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollment_subjects');
        Schema::dropIfExists('enrollments');
    }
};
