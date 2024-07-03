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
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id")->default(0);
            $table->integer("transaction_id")->default(0);
            $table->integer("subscription_id")->default(0);
            $table->string("plan_duration")->nullable()->comment("plan duration in days");
            $table->enum(
                'status',['active', 'cancelled','pending','inactive']
            );
            $table->date("start_date")->comment("subscription start date");
            $table->date("end_date")->comment("subscription end date");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_subscriptions');
    }
};
