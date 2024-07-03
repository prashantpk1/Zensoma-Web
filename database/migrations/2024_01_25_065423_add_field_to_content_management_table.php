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
            $table->string('creater_id')->after('status')->nullable();
            $table->string('creater_name')->after('creater_id')->nullable();
            $table->string('creater_type')->after('creater_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('content_management', function (Blueprint $table) {
            //
            $table->dropColumn('creater_id');
            $table->dropColumn('creater_name');
            $table->dropColumn('creater_type');
        });
    }
};
