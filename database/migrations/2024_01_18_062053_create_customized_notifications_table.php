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
        Schema::create('customized_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content');
            $table->enum(
                'notification_type',['email','push_notification','both']
            )->nullable()->comment("notification_type (email,push_notification,both)");
            $table->enum(
                'user_type',['customer','subadmin','both']
            )->nullable()->comment("user_type (customer,subadmin,both)");
            $table->integer('status')->nullable()->default(0);
            $table->integer('is_delete')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customized_notifications');
    }
};
