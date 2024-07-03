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
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->longText("level_name")->nullable();
            $table->integer("level_minute_start")->default(0);
            $table->integer("level_minute_end")->default(0);
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
        Schema::dropIfExists('levels');
    }
};
