@include('admin.blocks.header')
<div class="container body">
    <div class="main_container">
        @include('admin.blocks.sidebar')

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Thêm Voucher</h3>
                    </div>

                    <div class="title_right">
                        <div class="col-md-5 col-sm-5  form-group row pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                    <button class="btn btn-secondary" type="button">Go!</button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="row">

                    <div class="col-md-12 col-sm-12 ">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Form</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content add-tours">

                                <!-- Smart Wizard -->
                                <p>Thêm thông tin chi tiết để tạo một tour mới và bắt đầu thu hút khách hàng!</p>
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Đã có lỗi xảy ra!</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <div class="card-body">
                                    <form action="{{ route('vouchers.store') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <!-- Cột trái -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="code" class="form-label">Mã voucher</label>
                                                    <input type="text" name="code" id="code" class="form-control" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="discount" class="form-label">Giá trị giảm</label>
                                                    <input type="number" name="discount" id="discount" class="form-control" step="0.01" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="discount_type" class="form-label">Loại giảm giá</label>
                                                    <select name="discount_type" id="discount_type" class="form-select" required>
                                                        <option value="percent">Phần trăm (%)</option>
                                                        <option value="fixed">Số tiền cố định</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="min_order_value" class="form-label">Giá trị đơn hàng tối thiểu</label>
                                                    <input type="number" name="min_order_value" id="min_order_value" class="form-control" step="0.01">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="max_usage" class="form-label">Số lần sử dụng tối đa</label>
                                                    <input type="number" name="max_usage" id="max_usage" class="form-control" min="1" required>
                                                </div>
                                            </div>

                                            <!-- Cột phải -->
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="start_date" class="form-label">Ngày bắt đầu</label>
                                                    <input type="text" name="start_date" id="start_date" class="form-control datetimepicker" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="end_date" class="form-label">Ngày kết thúc</label>
                                                    <input type="text" name="end_date" id="end_date" class="form-control datetimepicker" required>
                                                </div>

                                                <div class="form-check mb-3 mt-4">
                                                    <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" checked>
                                                    <label class="form-check-label" for="is_active">
                                                        Kích hoạt voucher
                                                    </label>
                                                </div>


                                            </div>
                                            <div class="text-end mt-4">
                                                <a href="{{ route('vouchers.index') }}" class="btn btn-secondary">Hủy</a>
                                                <button type="submit" class="btn btn-success">Lưu Voucher</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <!-- End SmartWizard Content -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
            <div class="pull-right">
                Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>
@include('admin.blocks.footer')