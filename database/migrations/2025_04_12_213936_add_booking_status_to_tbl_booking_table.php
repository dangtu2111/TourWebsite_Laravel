<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBookingStatusToTblBookingTable extends Migration
{
    public function up()
    {
        Schema::table('tbl_booking', function (Blueprint $table) {
            $table->string('bookingStatus', 10)->default('y')->change(); // hoặc after('tên_cột_trước_nó') nếu muốn
        });
    }

    public function down()
    {
        Schema::table('tbl_booking', function (Blueprint $table) {
            $table->dropColumn('bookingStatus');
        });
    }
}
