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
            $table->uuid('uid')->primary();
            $table->string('staff_name');
            $table->string('staff_identity')->unique();
            $table->string('staff_designation');
            $table->bigInteger('staff_contact')->unique();
            $table->string('staff_type');
            $table->string('staff_address');
            $table->string('staff_city');
            $table->string('staff_country');
            $table->string('staff_remarks');
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
