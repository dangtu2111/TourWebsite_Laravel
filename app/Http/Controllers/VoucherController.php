<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VoucherController extends Controller
{
    public function index()
    {
        $list_voucher = Voucher::all();
        $title = "Quản lí voucher";
        return view('admin.vouchers.index', compact('list_voucher', 'title'));
    }

    public function create()
    {
        $title = "Quản lí voucher";
        return view('admin.vouchers.create', compact('title'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'start_date' => Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'),
            'end_date' => Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d'),
            'is_active' => $request->has('is_active') ? true : false,
        ]);
        $validated = $request->validate([
            'code' => 'required|unique:vouchers|min:3|max:20',
            'discount' => 'required|numeric|min:0',
            'discount_type' => 'required|in:percent,fixed',
            'min_order_value' => 'nullable|numeric|min:0',
            'max_usage' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        Voucher::create($validated);
        return redirect()->route('vouchers.index')->with('success', 'Voucher created successfully');
    }

    public function show(Voucher $voucher)
    {
        $list_voucher = Voucher::all();
        $title = "Quản lí voucher";
        return view('admin.vouchers.index', compact('list_voucher', 'title'));
    }

    public function edit(Voucher $voucher)
    {
        $title = "Sửa voucher";
        return view('admin.vouchers.edit', compact('voucher', 'title'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $request->merge([
            'start_date' => Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'),
            'end_date' => Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d'),
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        $validated = $request->validate([
            'code' => 'required|min:3|max:20|unique:vouchers,code,' . $voucher->id,
            'discount' => 'required|numeric|min:0',
            'discount_type' => 'required|in:percent,fixed',
            'min_order_value' => 'nullable|numeric|min:0',
            'max_usage' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
        ]);
        $voucher->update($validated);

        return redirect()->route('vouchers.index')->with('success', 'Voucher updated successfully');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();
        return redirect()->route('vouchers.index')->with('success', 'Voucher deleted Ascending deleted successfully.');
    }

    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string'
        ]);

        $voucher = Voucher::where('code', $request->code)
            ->where('is_active', true)
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->whereColumn('used_count', '<', 'max_usage')
            ->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired voucher code'
            ], 404);
        }

        // Logic áp dụng voucher (ví dụ: tính giảm giá)
        // Tùy vào cấu trúc bảng `vouchers`, bạn có thể trả các thông tin như sau:
        return response()->json([
            'success' => true,
            'message' => 'Voucher applied successfully',
            'data' => [
                'code' => $voucher->code,
                'discount_type' => $voucher->discount_type,
                'discount' => $voucher->discount,
                'max_usage' => $voucher->max_usage,
                'used_count' => $voucher->used_count,
                'start_date' => $voucher->start_date,
                'end_date' => $voucher->end_date,
            ]
        ]);
    }
}
