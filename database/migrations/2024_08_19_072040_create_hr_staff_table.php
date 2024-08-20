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
        Schema::create('hr_staff', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('uid')->unique();
            $table->string('code')->unique();
            $table->string('hr_first_name');
            $table->string('hr_last_name');
            $table->string('hr_father_name');
            $table->string('hr_designation');
            $table->string('hr_department');
            $table->string('hr_job_type');
            $table->string('hr_nationality');
            $table->integer('hr_gender');
            $table->string('hr_identity')->unique();
            $table->date('hr_identity_expiry');
            $table->bigInteger('hr_contact')->unique();
            $table->string('hr_type')->nullable();
            $table->string('hr_address');
            $table->string('hr_city');
            $table->string('hr_country');
            $table->date('hr_dob');
            $table->date('hr_doj');
            $table->string('employee_type');
            $table->string('hr_status');
            $table->string('hr_security_status')->default('pending');
            $table->string('hr_remarks')->nullable();
            $table->uuid('hr_uid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_staff');
    }
};
