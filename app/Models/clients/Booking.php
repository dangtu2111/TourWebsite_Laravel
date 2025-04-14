<?php

namespace App\Models\clients;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class Booking extends Model
{
    use HasFactory;

    protected $table = 'tbl_booking';

    public function createBooking($data)
    {
        // Chèn dữ liệu và trả về ID của bản ghi vừa tạo
        return DB::table($this->table)->insertGetId($data);
    }

    public function cancelBooking($bookingId)
    {
        return DB::table($this->table)
            ->where('bookingId', $bookingId)
            ->update(['bookingStatus' => 'c']);
    }

    public function checkTourDate($bookingId)
    {
        // Lấy thông tin booking từ bảng tbl_booking, có thể sử dụng tourId
        $getBookingDetail = DB::table('tbl_booking')
            ->where('bookingId', $bookingId)
            ->first();

        // Kiểm tra nếu không tìm thấy booking
        if (!$getBookingDetail) {
            return false; // Hoặc bạn có thể ném ra lỗi nếu cần
        }

        // Lấy thông tin startDate từ tour liên quan tới booking
        $tourId = $getBookingDetail->tourId;
       
        $getTourDetail = DB::table('tbl_tours')
            ->where('tourId', $tourId)
            ->first();

        // Kiểm tra nếu không tìm thấy tour
        if (!$getTourDetail) {
            return false;
        }

        // Chuyển startDate của tour thành đối tượng Carbon
        $startDate = Carbon::parse($getTourDetail->startDate);
        $now = Carbon::now();

        // Kiểm tra nếu ngày bắt đầu của tour cách ngày hiện tại ít hơn 3 ngày
        if ($startDate->diffInDays($now, false) < 3) {
            return false;
        }

        return true;
    }



    public function checkBooking($tourId, $userId)
    {
        return DB::table($this->table)
            ->where('tourId', $tourId)
            ->where('userId', $userId)
            ->where('bookingStatus', 'f')
            ->exists(); // Trả về true nếu bản ghi tồn tại, false nếu không tồn tại
    }
}
