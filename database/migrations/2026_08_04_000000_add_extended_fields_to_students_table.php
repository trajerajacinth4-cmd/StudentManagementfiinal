<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('student_number')->nullable()->unique()->after('id');
            $table->string('status')->default('Active')->after('year_level');
            $table->decimal('gpa', 3, 2)->nullable()->after('status');
            $table->string('avatar')->nullable()->after('gpa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['student_number', 'status', 'gpa', 'avatar']);
        });
    }
};
