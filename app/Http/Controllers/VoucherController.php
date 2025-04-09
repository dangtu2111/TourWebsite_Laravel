<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::all();
        return view('vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        return view('vouchers.create');
    }

    public function store(Request $request)
    {
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
        return view('vouchers.show', compact('voucher'));
    }

    public function edit(Voucher $voucher)
    {
        return view('vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, Voucher $voucher)
    {
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
            return back()->withErrors(['code' => 'Invalid or expired voucher code']);
        }

        // Logic áp dụng voucher vào giỏ hàng
        // Đây là nơi bạn sẽ tính toán giá trị giảm giá dựa trên discount_type và discount
        return redirect()->back()->with('success', 'Voucher applied successfully');
    }
}