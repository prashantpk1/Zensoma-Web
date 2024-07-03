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
        Schema::create('challenge_friends', function (Blueprint $table) {
            $table->id();
            $table->integer("session_id");
            $table->integer("challenge_from")->comment("Challenge sender user_id");
            $table->integer("challenge_to")->comment("Challenge reciver user_id");
            $table->string("status")->comment("complate,pendding");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challenge_friends');
    }
};
