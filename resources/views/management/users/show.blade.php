
@extends('master')

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title  hidden-print">
                <div class="title_left">
                    <h3>پروفایل کاربر
                        <a href="{{ route('admin.management.users.index') }}">
                            <small>بازگشت به صفحه مدیریت پرسنل</small>
                        </a>
                    </h3>

                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>اطلاعات
                            </h2>
                            <ul class="nav navbar-right panel_toolbox hidden-print">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <section class="content invoice">
                                <!-- title row -->
                                <div class="row">
                                    <div class="col-xs-12 invoice-header">
                                        <h1>
                                            <small class="pull-left">{{ $date }}</small>
                                        </h1>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- info row -->
                                <div class="row invoice-info">
                                    <!-- /.col -->
                                    <div class="col-xs-12 col-sm-4 invoice-col">
                                        <br>
                                        <br>
                                        <b>نام:</b> {{ $user->first_name }}
                                        <br>
                                        <b>نام خانوادگی:</b> {{ $user->last_name }}
                                        <br>
                                        <b>کد پرسنلی:</b> {{ $user->identification_code }}
                                        <br>
                                        <b>کد حسابداری:</b> {{ $user->accounting_code }}
                                        <br>
                                        <b>محل خدمت:</b> {{ $user->site->title }}
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <hr>
                                <!-- this row will not appear when printing -->
                                <div class="row no-print hidden-print">
                                    <div class="col-xs-12">
                                        <button class="btn btn-default" onclick="window.print();"><i
                                                class="fa fa-print"></i> چاپ
                                        </button>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->


@endsection
