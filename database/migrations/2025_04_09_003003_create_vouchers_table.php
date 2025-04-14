<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('vouchers');
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Mã voucher
            $table->decimal('discount', 15, 2); // Giá trị giảm giá
            $table->enum('discount_type', ['percent', 'fixed']); // Loại giảm giá: phần trăm hoặc cố định
            $table->decimal('min_order_value', 15, 2)->nullable(); // Giá trị đơn hàng tối thiểu
            $table->integer('max_usage')->default(1); // Số lần sử dụng tối đa
            $table->integer('used_count')->default(0); // Số lần đã sử dụng
            $table->dateTime('start_date'); // Ngày bắt đầu hiệu lực
            $table->dateTime('end_date'); // Ngày hết hạn
            $table->boolean('is_active')->default(true); // Trạng thái hoạt động
            $table->timestamps();
        });
       
    }

    public function down()
    {
        Schema::dropIfExists('vouchers');
        Schema::table('tbl_checkout', function (Blueprint $table) {
            $table->dropColumn('paymentDate');
        });
    }
}