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
        Schema::create('predefined_questions', function (Blueprint $table) {
            $table->id();
            $table->longText('question');
            $table->longText('options');
            $table->enum(
                'option_type',['checkbox','radio','range','multipleselect','select']
            )->nullable()->comment("option_type (checkbox,radio,range,multipleselect,select)");
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
        Schema::dropIfExists('predefined_questions');
    }
};
