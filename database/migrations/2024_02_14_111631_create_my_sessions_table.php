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
        Schema::create('my_sessions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0);
            $table->integer('session_id')->default(0);
            $table->json('category_id')->nullable();
            $table->integer('status')->comment("0:complate,1:pendding");
            $table->string('push_time')->nullable();
            $table->integer('minute_spend')->nullable();
            $table->integer('is_delete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_sessions');
    }
};
