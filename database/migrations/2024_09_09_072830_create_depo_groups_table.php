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
        Schema::create('depo_groups', function (Blueprint $table) {
            $table->uuid('uid')->primary();
            $table->bigInteger('staff_quantity');
            $table->string('depo_rep_name');
            $table->string('depo_rep_contact');
            $table->string('depo_rep_email')->unique();
            $table->string('depo_rep_phone')->nullable();
            $table->uuid('depo_rep_uid')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depo_groups');
    }
};
