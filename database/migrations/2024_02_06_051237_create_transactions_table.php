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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id")->nullable()->default(0);
            $table->enum(
                'payment_mode',['direct_payment', 'wallet']
            );
            $table->enum(
                'transaction_type',['subscription','indivisual_session','booking']
            );
            $table->integer("subscription_id")->nullable()->default(0);
            $table->integer("session_id")->nullable()->default(0);
            $table->float("amount")->nullable()->default(0);
            $table->enum(
                'status',['success','failed','pendding']
            );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
