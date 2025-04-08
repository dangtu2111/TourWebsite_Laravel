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
        Schema::create('tbl_booking', function (Blueprint $table) {
            $table->id('bookingId'); // khóa chính tự tăng
            $table->string('address'); // cột password
            $table->string('fullName')->nullable(); // Tên đầy đủ
            $table->string('email')->nullable(); // cột email, nullable
            $table->string('phoneNumber')->nullable(); // Số điện thoại
            $table->unsignedBigInteger('tourId'); // Sử dụng unsignedBigInteger để khóa ngoại
            $table->unsignedBigInteger('userId'); // Sử dụng unsignedBigInteger để khóa ngoại
            $table->foreign('userId')->references('userId')->on('tbl_users'); // Khóa ngoại đến bảng tbl_tours
            $table->foreign('tourId')->references('tourId')->on('tbl_tours')->onDelete('cascade'); // Khóa ngoại đến bảng tbl_tours
            $table->string('bookingStatus', 10)->default('f');
            $table->integer('numChildren')->default(0);
            $table->decimal('totalPrice', 10, 2)->default(0);
            $table->integer('numAdults')->default(0); // Thêm cột 'bookingStatus'
            // $table->date('bookingDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->date('bookingDate')->nullable();
            
            $table->timestamps(); // created_at và updated_at
        });
        Schema::create('tbl_checkout', function (Blueprint $table) {
            $table->id('checkoutId'); // Khóa chính tự tăng
            $table->unsignedBigInteger('bookingId'); // Khóa ngoại tới bảng tbl_booking
            $table->decimal('amount', 10, 2); // Số tiền thanh toán
            $table->string('paymentMethod'); // Phương thức thanh toán
            $table->string('paymentStatus')->default('pending'); // Trạng thái thanh toán
            $table->dateTime('paymentDate')->nullable();
            $table->timestamps();

            // Định nghĩa khóa ngoại
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
        Schema::dropIfExists('tbl_booking');
        Schema::dropIfExists('tbl_checkout');

    }
};
