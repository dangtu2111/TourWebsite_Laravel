<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->decimal('discount', 15, 2)->change(); // Cập nhật độ chính xác
            $table->decimal('min_order_value', 15, 2)->nullable()->change(); // Cập nhật độ chính xác
        });
    }

    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            $table->decimal('discount', 8, 2)->change(); // Khôi phục lại mặc định cũ
            $table->decimal('min_order_value', 8, 2)->nullable()->change(); // Khôi phục mặc định cũ
        });
    }
};

