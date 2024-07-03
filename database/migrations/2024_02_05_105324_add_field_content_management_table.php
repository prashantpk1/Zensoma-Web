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
            $table->integer("purchase_type")->after("content_type")->nullable()->comment('0 = indivisual',"1 = subscription");
            $table->float("price")->after("purchase_type")->nullable()->comment("price when purchase type = 0");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('content_management', function (Blueprint $table) {
            //
            $table->dropColumn('purchase_type');
            $table->dropColumn('price');
        });
    }
};
