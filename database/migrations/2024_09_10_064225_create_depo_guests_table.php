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
            $table->string('depo_guest_contact');
            $table->string('hr_identity')->unique();
            $table->string('depo_guest_email')->nullable();
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
