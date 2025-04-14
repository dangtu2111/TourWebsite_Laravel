<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void
    {
        Schema::table('tbl_booking', function (Blueprint $table) {
            $table->unsignedBigInteger('voucher_id')->nullable();
            $table->foreign('voucher_id')->references('id')->on('vouchers')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_booking', function (Blueprint $table) {
            $table->dropForeign(['voucher_id']);
            $table->dropColumn('voucher_id');
        });
    }
};
