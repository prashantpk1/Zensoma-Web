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
        Schema::create('buddy_network_details', function (Blueprint $table) {
            $table->id();
            $table->integer('buddy_network_id')->default(0);
            $table->integer('user_id')->default(0)->comment("Referral Submit User Id");
            $table->integer('status')->default(0);
            $table->integer('is_delete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buddy_network_details');
    }
};
