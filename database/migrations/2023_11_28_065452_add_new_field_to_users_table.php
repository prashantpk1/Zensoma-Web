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
        Schema::table('users', function (Blueprint $table) {
            //
           $table->integer('user_type')->default(0)->comment("0=user,1=(sub admin),2=(super admin)");
            $table->string('profile_image');
            $table->string('phone');
            $table->string('gender');
            $table->string('referral_code');
            $table->string('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('user_type');
            $table->dropColumn('profile_image');
            $table->dropColumn('phone');
            $table->dropColumn('gender');
            $table->dropColumn('referral_code');
            $table->dropColumn('status');
        });
    }
};
