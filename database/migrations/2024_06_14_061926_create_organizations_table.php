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
        Schema::create('organizations', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->string('company_category');
            $table->string('company_name');
            $table->string('company_address');
            // $table->string('company_type');
            $table->string('company_city');
            $table->string('company_country');
            $table->string('company_contact');
            // $table->bigInteger('company_ntn')->nullable();
            $table->string('company_owner');
            $table->string('company_owner_designation');
            $table->string('company_owner_contact');
            $table->bigInteger('staff_quantity');
            $table->string('company_rep_name');
            // $table->string('company_rep_designation');
            // $table->string('company_rep_dept');
            $table->string('company_rep_contact');
            $table->string('company_rep_email')->unique();
            $table->string('company_rep_phone')->nullable();
            $table->uuid('company_rep_uid')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
