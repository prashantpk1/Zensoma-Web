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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_id')->default(0);
            $table->integer('therapist_id');
            $table->integer('user_id');
            $table->string('date');
            $table->string('start_time');
            $table->string('end_time');
            $table->integer('slot_id')->default(0);
            $table->integer('is_live')->default(0)->comment('0 not live,1 live');;
            $table->enum('status',['confirm','complete','pending','cancel']);
            $table->integer("is_delete")->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
