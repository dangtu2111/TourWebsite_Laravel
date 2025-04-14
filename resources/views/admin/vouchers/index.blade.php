@include('admin.blocks.header')
<div class="container body">
    <div class="main_container">
        @include('admin.blocks.sidebar')

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Quản lý <small>Voucher</small></h3>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 ">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Voucher</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card-box table-responsive">
                                            <p class="text-muted font-13 m-b-30">
                                                Chào mừng bạn đến với trang quản lý Voucher đã đặt. Tại đây, bạn có thể xác nhận,
                                                xem chi tiết, và quản lý tất cả các Voucher đã được đặt hiện có.
                                            </p>
                                            <table id="datatable-voucher" class="table table-striped table-bordered"
                                                style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Mã Code</th>
                                                        <th>Giảm giá</th>
                                                        <th>Loại Giảm giá</th>
                                                        <th>Giá trị đơn tối thiểu</th>
                                                        <th>Số lượng</th>
                                                        <th>Đã sử dụng</th>
                                                        <th>Còn lại</th>
                                                        <th>Ngày bắt đầu</th>
                                                        <th>Ngày hết hạn</th>
                                                        <th>Trạng thái</th>
                                                        <th>Ngày tạo</th>
                                                        <th>Hành động</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody-voucher">
                                                    @include('admin.partials.list-voucher')
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
    </div>
</div>
@include('admin.blocks.footer')