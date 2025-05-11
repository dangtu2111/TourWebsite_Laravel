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
        // Tạo bảng users
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Tạo bảng tbl_users
        Schema::create('tbl_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('userId'); // Khóa chính
            $table->string('username')->unique(); // Tên đăng nhập
            $table->string('email')->unique(); // Email
            $table->string('password'); // Mật khẩu
            $table->string('isActive')->nullable();
            $table->string('avatar')->nullable();
            $table->string('activation_token')->nullable();
            $table->string('fullName')->nullable(); // Tên đầy đủ
            $table->string('phoneNumber')->nullable(); // Số điện thoại
            $table->string('address')->nullable(); // Địa chỉ
            $table->string('status')->nullable(); // Trạng thái
            $table->timestamps(); // Thêm created_at và updated_at
        });

        // Tạo bảng tbl_admin
        Schema::create('tbl_admin', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id(); // Khóa chính tự tăng
            $table->string('username')->unique(); // Cột username (unique)
            $table->string('password'); // Cột password
            $table->string('fullname'); // Cột họ tên
            $table->string('address'); // Cột địa chỉ
            $table->string('email')->nullable(); // Cột email, nullable
            $table->timestamps(); // created_at và updated_at
        });

        // Tạo bảng tbl_tours
        Schema::create('tbl_tours', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('tourId'); // Khóa chính tự tăng
            $table->string('title'); // Tiêu đề tour
            $table->enum('domain', ['b', 't', 'n']); // Miền của tour
            $table->text('description')->nullable(); // Mô tả tour
            $table->decimal('priceAdult', 10, 2)->nullable(); // Giá vé người lớn
            $table->decimal('priceChild', 10, 2)->nullable(); // Giá vé trẻ em
            $table->string('destination')->nullable(); // Điểm đến
            $table->text('time'); // Thời gian tour
            $table->integer('quantity'); // Số lượng vé tour
            $table->integer('availability')->default(1); // Tình trạng có sẵn của tour (0 = không có, 1 = có)
            $table->date('startDate')->nullable(); // Ngày bắt đầu tour
            $table->date('endDate')->nullable(); // Ngày kết thúc tour
            $table->timestamps(); // created_at và updated_at
        });

        // Tạo bảng tbl_booking
        Schema::create('tbl_booking', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('bookingId'); // Khóa chính tự tăng
            $table->string('address'); // Địa chỉ
            $table->string('fullName')->nullable(); // Tên đầy đủ
            $table->string('email')->nullable(); // Cột email, nullable
            $table->string('phoneNumber')->nullable(); // Số điện thoại
            $table->unsignedBigInteger('tourId'); // Khóa ngoại
            $table->unsignedBigInteger('userId'); // Khóa ngoại
            $table->foreign('userId')->references('userId')->on('tbl_users')->onDelete('cascade'); // Khóa ngoại đến bảng tbl_users
            $table->foreign('tourId')->references('tourId')->on('tbl_tours')->onDelete('cascade'); // Khóa ngoại đến bảng tbl_tours
            $table->string('bookingStatus', 10)->default('y');
            $table->integer('numChildren')->default(0);
            $table->decimal('totalPrice', 10, 2)->default(0);
            $table->integer('numAdults')->default(0);
            $table->date('bookingDate')->nullable();
            $table->timestamps(); // created_at và updated_at
        });

        // Tạo bảng tbl_contact
        Schema::create('tbl_contact', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('contactId'); // Khóa chính tự tăng
            $table->string('fullName'); // Tên người liên hệ
            $table->string('phoneNumber')->nullable(); // Số điện thoại
            $table->string('email'); // Email người liên hệ
            $table->text('message'); // Tin nhắn người liên hệ gửi
            $table->enum('isReply', ['y', 'n'])->default('n'); // Trạng thái trả lời
            $table->timestamps(); // created_at và updated_at
        });

        // Tạo bảng tbl_checkout
        Schema::create('tbl_checkout', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('checkoutId'); // Khóa chính tự tăng
            $table->unsignedBigInteger('bookingId'); // Khóa ngoại tới bảng tbl_booking
            $table->decimal('amount', 10, 2); // Số tiền thanh toán
            $table->string('paymentMethod'); // Phương thức thanh toán
            $table->string('paymentStatus')->default('pending'); // Trạng thái thanh toán
            $table->dateTime('paymentDate')->nullable();
            $table->string('transactionId')->nullable();
            $table->timestamps();
            $table->foreign('bookingId')->references('bookingId')->on('tbl_booking')->onDelete('cascade');
        });

        // Tạo bảng tbl_timeline
        Schema::create('tbl_timeline', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('timeLineId');
            $table->timestamp('event_date')->nullable();
            $table->unsignedBigInteger('tourId'); // Khóa ngoại
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('event')->nullable();
            $table->timestamps();
            $table->foreign('tourId')->references('tourId')->on('tbl_tours')->onDelete('cascade');
        });

        // Tạo bảng tbl_images
        Schema::create('tbl_images', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedBigInteger('tourId'); // Khóa ngoại tham chiếu đến bảng tbl_tours
            $table->string('imageURL'); // URL của hình ảnh
            $table->text('description')->nullable(); // Mô tả cho hình ảnh
            $table->timestamps();
            $table->foreign('tourId')->references('tourId')->on('tbl_tours')->onDelete('cascade');
        });

        // Tạo bảng tbl_reviews
        Schema::create('tbl_reviews', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('reviewId'); // Khóa chính tự tăng
            $table->unsignedBigInteger('tourId'); // Khóa ngoại đến bảng tours
            $table->unsignedBigInteger('userId'); // Khóa ngoại đến bảng users
            $table->text('comment'); // Bình luận của người dùng
            $table->tinyInteger('rating'); // Đánh giá từ 1 đến 5
            $table->timestamps();
            $table->timestamp('timestamp')->nullable();
            $table->foreign('tourId')->references('tourId')->on('tbl_tours')->onDelete('cascade');
            $table->foreign('userId')->references('userId')->on('tbl_users')->onDelete('cascade');
        });

        // Tạo bảng tbl_temp_images
        Schema::create('tbl_temp_images', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id(); // Khóa chính
            $table->unsignedBigInteger('tourId'); // Khóa ngoại
            $table->string('imageTempURL'); // URL của hình ảnh tạm
            $table->timestamps();
            $table->foreign('tourId')->references('tourId')->on('tbl_tours')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('tbl_admin');
        Schema::dropIfExists('tbl_booking');
        Schema::dropIfExists('tbl_contact');
        Schema::dropIfExists('tbl_tours');
        Schema::dropIfExists('tbl_checkout');
        Schema::dropIfExists('tbl_timeline');
        Schema::dropIfExists('tbl_images');
        Schema::dropIfExists('tbl_reviews');
        Schema::dropIfExists('tbl_temp_images');
        Schema::dropIfExists('tbl_users');
    }
};