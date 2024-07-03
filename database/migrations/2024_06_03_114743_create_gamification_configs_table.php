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
        Schema::create('gamification_configs', function (Blueprint $table) {
            $table->id();
            $table->longText("config_name")->nullable();
            $table->string("config_key")->nullable();
            $table->string("config_value")->nullable();
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
        Schema::dropIfExists('gamification_configs');
    }
};
