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
        Schema::create('user_sleep_details', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->date("sleep_start_date");
            $table->date("sleep_end_date");
            $table->time("sleep_start_time");
            $table->time("sleep_end_time");
            $table->string("duration");
            $table->longText("sleep_log");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_sleep_details');
    }
};
