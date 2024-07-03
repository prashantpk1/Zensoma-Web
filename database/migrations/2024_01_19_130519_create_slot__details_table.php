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
        Schema::create('slot__details', function (Blueprint $table) {
            $table->id();
            $table->integer('slot_id')->default(0);
            $table->string('start_time');
            $table->string('end_time');
            $table->string('duration');
            $table->integer('is_available')->default(0)->nullable();
            // $table->enum(
            //     'is_available',['book','available']
            // )->nullable()->comment("is_available (book,available)");
            $table->timestamp('is_available_update_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slot__details');
    }
};
