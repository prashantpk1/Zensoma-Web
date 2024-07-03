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
        Schema::table('predefined_questions', function (Blueprint $table) {
            //
            $table->longText("category_id")->after('option_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('predefined_questions', function (Blueprint $table) {
            //
            $table->dropColumn('category_id');
           });
    }
};
