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
        Schema::create('content_management', function (Blueprint $table) {
            $table->id();
            $table->longText('title');
            $table->longText('description');
            $table->string('file')->nullable();
            $table->string('duration');
            $table->enum(
                'content_type',['content', 'video','audio']
            )->nullable()->comment("content type (content,video,audio)");
            $table->integer('category_id')->nullable()->default(0);
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
        Schema::dropIfExists('content_management');
    }
};
