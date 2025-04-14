@if(isset($list_voucher))
@foreach ($list_voucher as $voucher)
<tr>
    <td>{{ $voucher->id }}</td>
    <td>{{ $voucher->code }}</td>
    <td>{{ number_format($voucher->discount, 0, ',', '.') }}
        @if ($voucher->discount_type == 'percent')%
        @else đ
        @endif
    </td>
    <td>
        @if ($voucher->discount_type == 'percent')
        Phần trăm
        @else
        Cố định
        @endif
    </td>
    <td>{{ $voucher->min_order_value ? number_format($voucher->min_order_value, 0, ',', '.') . ' đ' : 'Không yêu cầu' }}</td>
    <td>{{ $voucher->max_usage }}</td>
    <td>{{ $voucher->used_count }}</td>
    <td>{{ $voucher->max_usage - $voucher->used_count }}</td>
    <td>{{ \Carbon\Carbon::parse($voucher->start_date)->format('d-m-Y') }}</td>
    <td>{{ \Carbon\Carbon::parse($voucher->end_date)->format('d-m-Y') }}</td>
    <td>
        @if ($voucher->is_active)
        <span class="badge badge-success">Hoạt động</span>
        @else
        <span class="badge badge-secondary">Tạm ngưng</span>
        @endif
    </td>
    <td>{{ \Carbon\Carbon::parse($voucher->created_at)->format('d-m-Y H:i') }}</td>
    <td>
        <div class="btn-group">
            <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('vouchers.edit', $voucher->id) }}">Sửa</a>
                <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form').submit();" class="dropdown-item">Xóa</a>

                <form id="delete-form" action="{{ route('vouchers.destroy', $voucher->id) }}" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE') <!-- Chỉ định phương thức DELETE -->
                </form>

            </div>
        </div>
    </td>
</tr>
@endforeach
@endif