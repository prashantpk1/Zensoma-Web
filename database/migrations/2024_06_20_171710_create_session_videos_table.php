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
        Schema::create('session_videos', function (Blueprint $table) {
            $table->id();
            $table->integer("session_id");
            $table->string("thumbnail_image");
            $table->string("video_audio_file");
            $table->integer("status");
            $table->integer("is_delete")->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_videos');
    }
};
