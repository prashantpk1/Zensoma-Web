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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id")->comment("User Detail Which Share how refercode to other");
            $table->integer("total_refer_count")->default(0);
            $table->integer("total_challenge_complate_count")->default(0);
            $table->integer("total_minute_spend")->default(0);
            $table->integer("current_level_id")->default(0);
            $table->longText("badge_ids")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
