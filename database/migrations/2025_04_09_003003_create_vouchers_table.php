<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();              // Mã voucher
            $table->decimal('discount', 8, 2);              // Giá trị giảm (ví dụ: 50.00)
            $table->enum('type', ['percent', 'fixed']);     // Loại giảm: phần trăm hoặc cố định
            $table->integer('quantity')->default(1);        // Số lượng còn lại
            $table->timestamp('start_date')->nullable();    // Ngày bắt đầu có hiệu lực
            $table->timestamp('end_date')->nullable();      // Ngày hết hạn
            $table->boolean('is_active')->default(true);    // Voucher đang hoạt động?
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}