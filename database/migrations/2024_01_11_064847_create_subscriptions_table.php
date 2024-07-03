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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->comment("Used for in app perchuse");
            $table->longText('name');
            $table->string('image')->nullable();
            $table->longText('description');
            $table->string('featured');
            $table->integer('duration')->comment("Duration(In Day)");
            $table->integer('amount')->default(0);
            $table->enum(
                'subscription_type',['whole_system', 'categories_wise']
            )->nullable();
            $table->string('category_id')->nullable();
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
        Schema::dropIfExists('subscriptions');
    }
};
