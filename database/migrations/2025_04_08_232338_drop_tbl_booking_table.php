<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {   Schema::table('tbl_checkout', function (Blueprint $table) {
            $table->dropForeign(['bookingId']);
        });
        Schema::dropIfExists('tbl_booking');
        Schema::dropIfExists('tbl_checkout');

    }

    public function down(): void
    {
        Schema::table('tbl_checkout', function (Blueprint $table) {
            $table->foreign('bookingId')->references('id')->on('tbl_booking');
        });
    }
};
