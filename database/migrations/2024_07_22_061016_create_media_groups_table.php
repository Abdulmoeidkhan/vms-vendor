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
        Schema::create('media_groups', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->string('media_category');
            $table->string('media_name');
            $table->string('media_address');
            $table->string('media_city');
            $table->string('media_country');
            $table->string('media_contact');
            $table->string('media_owner');
            $table->string('media_owner_designation');
            $table->string('media_owner_contact');
            $table->bigInteger('staff_quantity');
            $table->string('media_rep_name');
            $table->string('media_rep_contact');
            $table->string('media_rep_email')->unique();
            $table->string('media_rep_phone')->nullable();
            $table->uuid('media_rep_uid')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_groups');
    }
};
