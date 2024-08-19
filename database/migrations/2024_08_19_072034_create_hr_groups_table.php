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
        Schema::create('hr_groups', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->string('hr_category');
            $table->string('hr_name');
            $table->string('hr_address');
            $table->string('hr_city');
            $table->string('hr_country');
            $table->string('hr_contact');
            $table->string('hr_owner');
            $table->string('hr_owner_designation');
            $table->string('hr_owner_contact');
            $table->bigInteger('staff_quantity');
            $table->string('hr_rep_name');
            $table->string('hr_rep_contact');
            $table->string('hr_rep_email')->unique();
            $table->string('hr_rep_phone')->nullable();
            $table->uuid('hr_rep_uid')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_groups');
    }
};
