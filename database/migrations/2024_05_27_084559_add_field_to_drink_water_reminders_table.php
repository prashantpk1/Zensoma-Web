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
        Schema::table('drink_water_reminders', function (Blueprint $table) {
            //
            $table->integer("remind_me_every_hour_number")->after('reminder_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('drink_water_reminders', function (Blueprint $table) {
            //
            $table->dropColumn('remind_me_every_hour_number');
        });
    }
};
