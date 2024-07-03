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
        Schema::table('walk_reminders', function (Blueprint $table) {
            //
            $table->integer("reminder_switch")->after("reminder_me_every_day_at")->comment("0 = on,1 = Off")->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('walk_reminders', function (Blueprint $table) {
            //
            $table->dropColumn('reminder_switch');
        });
    }
};
