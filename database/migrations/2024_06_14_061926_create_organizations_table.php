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
            $table->string('company_type');
            $table->string('company_city');
            $table->string('company_country');
            $table->bigInteger('company_contact')->unique();
            $table->bigInteger('company_ntn')->unique();
            $table->string('company_owner');
            $table->string('company_owner_designation');
            $table->bigInteger('company_owner_contact')->unique();

            $table->string('company_rep_name');
            $table->string('company_rep_designation');
            $table->string('company_rep_dept')->unique();
            $table->string('company_rep_contact')->unique();
            $table->string('company_rep_email')->unique();
            $table->string('company_rep_phone')->unique();
            $table->uuid('company_rep_uid')->nullable();
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
