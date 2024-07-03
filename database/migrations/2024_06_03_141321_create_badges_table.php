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
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->longText("badge_name")->nullable();
            $table->string("badge_image")->nullable();
            $table->integer("badge_required_minute")->nullable();
            $table->integer("badge_required_number_refer")->nullable();
            $table->integer("badge_required_challenge")->nullable();
            $table->integer("status");
            $table->integer("is_delete")->default(0)->nullable();
            $table->integer("is_default")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badges');
    }
};
