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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('tbl_users', function (Blueprint $table) {
            $table->id('userId'); // Khóa chính
            $table->string('username')->unique(); // Tên đăng nhập
            $table->string('email')->unique(); // Email
            $table->string('password'); // Mật khẩu
            $table->string('isActive')->nullable();
            $table->string('avatar')->nullable();
            $table->string('activation_token')->nullable();
            $table->string('fullName')->nullable(); // Tên đầy đủ
            $table->string('phoneNumber')->nullable(); // Số điện thoại
            $table->string('address')->nullable(); // Số điện thoại
            $table->string('status')->nullable(); // Số điện thoại
            $table->timestamps(); // Thêm created_at và updated_at
        });

        // Tạo bảng tbl_admin
        Schema::create('tbl_admin', function (Blueprint $table) {
            $table->id(); // khóa chính tự tăng
            $table->string('username')->unique(); // cột username (unique)
            $table->string('password'); // cột password
            $table->string('fullname'); // cột password
            $table->string('address'); // cột password
            $table->string('email')->nullable(); // cột email, nullable
            $table->timestamps(); // created_at và updated_at
        });

        // Tạo bảng tbl_tours
        Schema::create('tbl_tours', function (Blueprint $table) {
            $table->id('tourId'); // Khóa chính tự tăng
            $table->string('title'); // Tiêu đề tour
            $table->enum('domain', ['b', 't', 'n']); // Miền của tour
            $table->text('description')->nullable(); // Mô tả tour
            $table->decimal('priceAdult', 10, 2)->nullable(); // Giá vé người lớn
            $table->decimal('priceChild', 10, 2)->nullable(); // Giá vé trẻ em
            $table->string('destination')->nullable(); // Điểm đến
            $table->text('time'); // Thời gian tour
            $table->integer('quantity'); // Số lượng vé tour
            $table->integer('availability')->default(1);// Tình trạng có sẵn của tour (0 = không có, 1 = có)
            $table->date('startDate')->nullable(); // Ngày bắt đầu tour
            $table->date('endDate')->nullable(); // Ngày kết thúc tour
            $table->timestamps(); // created_at và updated_at
        });
       
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
            $table->string('bookingStatus', 10)->default('y');
            $table->integer('numChildren')->default(0);
            $table->decimal('totalPrice', 10, 2)->default(0);
            $table->integer('numAdults')->default(0); // Thêm cột 'bookingStatus'
            // $table->date('bookingDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->date('bookingDate')->nullable();
            
            $table->timestamps(); // created_at và updated_at
        });

        // Tạo bảng tbl_contact
        Schema::create('tbl_contact', function (Blueprint $table) {
            $table->id('contactId'); // khóa chính tự tăng
            $table->string('fullName'); // Tên người liên hệ
            $table->string('phoneNumber')->nullable(); // Tên người liên hệ
            $table->string('email'); // Email người liên hệ
            $table->text('message'); // Tin nhắn người liên hệ gửi
            $table->enum('isReply', ['y', 'n'])->default('n'); // Trạng thái trả lời (y = đã trả lời, n = chưa trả lời)
            $table->timestamps(); // created_at và updated_at
        });
        Schema::create('tbl_checkout', function (Blueprint $table) {
            $table->id('checkoutId'); // Khóa chính tự tăng
            $table->unsignedBigInteger('bookingId'); // Khóa ngoại tới bảng tbl_booking
            $table->decimal('amount', 10, 2); // Số tiền thanh toán
            $table->string('paymentMethod'); // Phương thức thanh toán
            $table->string('paymentStatus')->default('pending'); // Trạng thái thanh toán
            $table->dateTime('paymentDate')->nullable();
            $table->string('transactionId')->nullable()->after('paymentStatus');
            $table->timestamps();

            // Định nghĩa khóa ngoại
            $table->foreign('bookingId')->references('bookingId')->on('tbl_booking')->onDelete('cascade');
        });
        Schema::create('tbl_timeline', function (Blueprint $table) {
            $table->id('timeLineId');
            $table->timestamp('event_date')->nullable();
            $table->unsignedBigInteger('tourId'); // thêm cột tourId
            $table->string('title'); 
            $table->text('description')->nullable();
            $table->string('event')->nullable()->change();
            $table->timestamps();
            $table->foreign('tourId')->references('tourId')->on('tbl_tours')->onDelete('cascade');
        });
        Schema::create('tbl_images', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('tourId'); // Khóa ngoại tham chiếu đến bảng tbl_tours
            $table->string('imageURL'); // Cột lưu trữ URL của hình ảnh
            $table->text('description')->nullable(); // Mô tả cho hình ảnh, có thể null
            $table->timestamps(); // created_at và updated_at
            $table->foreign('tourId')->references('tourId')->on('tbl_tours')->onDelete('cascade');
        });
        Schema::create('tbl_reviews', function (Blueprint $table) {
            $table->id('reviewId'); // Khóa chính tự tăng
            $table->unsignedBigInteger('tourId'); // Khóa ngoại đến bảng tours
            $table->unsignedBigInteger('userId'); // Khóa ngoại đến bảng users
            $table->text('comment'); // Bình luận của người dùng
            $table->tinyInteger('rating'); // Đánh giá từ 1 đến 5
            $table->timestamps(); // created_at và updated_at
            $table->timestamp('timestamp')->nullable(); // Thêm cột timestamp nếu cần
        
            // Thiết lập các khóa ngoại
            $table->foreign('tourId')->references('tourId')->on('tbl_tours')->onDelete('cascade');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::create('tbl_temp_images', function (Blueprint $table) {
            $table->id(); // Tự động thêm khóa chính (primary key)
            $table->unsignedBigInteger('tourId'); // tourId
            $table->string('imageTempURL'); // URL của hình ảnh tạm
            $table->timestamps(); // Thêm created_at và updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Xóa các bảng khi rollback migration
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