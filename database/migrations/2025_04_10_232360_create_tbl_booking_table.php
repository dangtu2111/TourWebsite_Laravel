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
        Schema::table('tbl_checkout', function (Blueprint $table) {
            $table->dropIndex('tbl_checkout_bookingid_foreign');
        });

        // Xóa bảng tbl_booking nếu đã tồn tại
        Schema::dropIfExists('tbl_booking');

        // Tạo lại bảng tbl_booking với các cột cần thiết
        Schema::create('tbl_booking', function (Blueprint $table) {
            $table->id('bookingId'); // Khóa chính tự tăng
            $table->string('address'); // Địa chỉ
            $table->string('fullName')->nullable(); // Họ tên
            $table->string('email')->nullable(); // Email
            $table->string('phoneNumber')->nullable(); // Số điện thoại

            $table->unsignedBigInteger('tourId'); // Khóa ngoại tour
            $table->unsignedBigInteger('userId'); // Khóa ngoại user

            $table->foreign('userId')->references('userId')->on('tbl_users'); // FK đến bảng tbl_users
            $table->foreign('tourId')->references('tourId')->on('tbl_tours')->onDelete('cascade'); // FK đến bảng tbl_tours

            $table->string('bookingStatus', 10)->default('y'); // Trạng thái booking
            $table->integer('numChildren')->default(0); // Số trẻ em
            $table->integer('numAdults')->default(0); // Số người lớn
            $table->decimal('totalPrice', 10, 2)->default(0); // Tổng giá

            $table->date('bookingDate')->nullable(); // Ngày đặt
            $table->timestamps(); // created_at & updated_at
        });

        // Thêm lại khóa ngoại bookingId vào bảng checkout
        Schema::table('tbl_checkout', function (Blueprint $table) {
            $table->foreign('bookingId')->references('bookingId')->on('tbl_booking')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
};
