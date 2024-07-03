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
        Schema::create('challenge_friend_details', function (Blueprint $table) {
            $table->id();
            $table->integer("challenge_friend_id");
            $table->integer("session_video_id");
            $table->string("status")->comment("0 => pendding,1 complete");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challenge_friend_details');
    }
};
