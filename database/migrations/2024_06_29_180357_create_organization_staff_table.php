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
        Schema::create('organization_staff', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('uid')->unique();
            $table->string('staff_first_name');
            $table->string('staff_last_name');
            $table->string('staff_father_name');
            $table->string('staff_designation');
            $table->string('staff_department');
            $table->string('staff_job_type');
            $table->string('staff_nationality');
            $table->string('staff_identity')->unique();
            $table->date('staff_identity_expiry');
            $table->bigInteger('staff_contact')->unique();
            $table->string('staff_type');
            $table->string('staff_address');
            $table->string('staff_city');
            $table->string('staff_country');
            $table->date('staff_dob');
            $table->date('staff_doj');
            $table->string('employee_type');
            $table->string('staff_status');
            $table->string('staff_security_status')->default('pending');
            $table->string('staff_remarks')->nullable();
            $table->uuid('company_uid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_staff');
    }
};
