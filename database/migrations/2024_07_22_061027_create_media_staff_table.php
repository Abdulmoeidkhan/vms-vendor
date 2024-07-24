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
        Schema::create('media_staff', function (Blueprint $table) {
            $table->id()->primary();
            $table->uuid('uid')->unique();
            $table->string('media_staff_first_name');
            $table->string('media_staff_last_name');
            $table->string('media_staff_father_name');
            $table->string('media_staff_designation');
            $table->string('media_staff_department');
            $table->string('media_staff_job_type');
            $table->string('media_staff_nationality');
            $table->integer('media_staff_gender');
            $table->string('media_staff_identity')->unique();
            $table->date('media_staff_identity_expiry');
            $table->bigInteger('media_staff_contact')->unique();
            $table->string('media_staff_type')->nullable();
            $table->string('media_staff_address');
            $table->string('media_staff_city');
            $table->string('media_staff_country');
            $table->date('media_staff_dob');
            $table->date('media_staff_doj');
            $table->string('employee_type');
            $table->string('media_staff_status');
            $table->string('media_staff_security_status')->default('pending');
            $table->string('media_staff_remarks')->nullable();
            $table->uuid('media_uid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_media_staff');
    }
};
