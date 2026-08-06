<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->foreignId('semester_id')->constrained()->onDelete('cascade');
            $table->decimal('grade', 5, 2)->nullable(); // e.g. 1.25, 3.00
            $table->string('remarks')->nullable(); // Passed, Failed, INC, DRP
            $table->timestamps();

            $table->unique(['student_id', 'subject_id', 'semester_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
