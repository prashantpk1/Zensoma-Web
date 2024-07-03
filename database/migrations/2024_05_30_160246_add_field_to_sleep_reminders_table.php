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
        Schema::table('sleep_reminders', function (Blueprint $table) {
            //
            $table->integer("start_time_switch")->after('user_id')->comment("0 = on,1 = Off")->default(0);
            $table->integer("end_time_switch")->after('start_time')->comment("0 = on,1 = Off")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sleep_reminders', function (Blueprint $table) {
            //
            $table->dropColumn('start_time_switch');
            $table->dropColumn('end_time_switch');
        });
    }
};
