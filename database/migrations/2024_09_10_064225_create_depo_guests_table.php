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
        Schema::create('depo_guests', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->string('depo_guest_name');
            $table->string('depo_guest_rank');
            $table->string('depo_guest_designation');
            $table->string('depo_guest_contact');
            $table->string('depo_guest_service');
            $table->string('depo_identity')->unique();
            $table->string('depo_guest_email')->nullable();
            $table->string('badge_type');
            $table->uuid('depo_uid')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depo_guests');
    }
};
