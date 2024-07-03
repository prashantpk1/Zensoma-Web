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
        Schema::table('my_sessions', function (Blueprint $table) {
            //
            $table->integer("session_video_id")->after("session_id");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('my_sessions', function (Blueprint $table) {
            //
            $table->dropColumn('session_video_id');
        });
    }
};
