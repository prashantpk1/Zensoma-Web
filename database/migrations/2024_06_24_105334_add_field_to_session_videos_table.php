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
        Schema::table('session_videos', function (Blueprint $table) {
            //
            $table->longText("video_title")->after("session_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('session_videos', function (Blueprint $table) {
            //
            $table->dropColumn('video_title');
        });
    }
};
