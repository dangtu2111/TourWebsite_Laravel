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
            $table->string('bookingStatus', 10)->default('f')->change();
            $table->integer('numChildren')->default(0);
            $table->decimal('totalPrice', 10, 2)->default(0);
            $table->integer('numAdults')->default(0); // Thêm cột 'bookingStatus'
            // $table->date('bookingDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->date('bookingDate')->nullable();
            $table->timestamps(); // created_at và updated_at
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
    }
};
