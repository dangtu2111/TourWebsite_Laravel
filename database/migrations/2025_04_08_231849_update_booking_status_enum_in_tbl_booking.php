<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_booking', function (Blueprint $table) {
            $table->enum('bookingStatus', ['y', 'f', 'c','b'])->default('f')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_booking', function (Blueprint $table) {
            $table->enum('bookingStatus', ['pending', 'confirmed', 'cancelled'])->default('pending')->change();
        });
    }
};
