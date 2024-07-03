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
        Schema::table('content_management', function (Blueprint $table) {
            //
            $table->integer("type_id")->after('category_id')->nullable();
            $table->longText("main_category_id")->after('price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('content_management', function (Blueprint $table) {
            //
            $table->dropColumn("type_id");
            $table->dropColumn("main_category_id");
        });
}
};
