
@extends('master')

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title  hidden-print">
                <div class="title_left">
                    <h3>نمایش محل خدمت
                </h3>
                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right">
                        <a href="{{ route('admin.management.sites.index') }}">
                            <button class="btn btn-block btn-dark">بازگشت</button>
                        </a>
                    </div>
                </div>

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
                                        <b>کد:</b> {{ $site->code }}
                                        <br>
                                        <b>عنوان:</b> {{ $site->title }}
                                        <br>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <div class="x_content">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered jambo_table bulk_action">
                                            <thead>
                                            <tr class="headings">
                                                <th class="column-title">شماره ردیف</th>
                                                <th class="column-title">نام</th>
                                                <th class="column-title">نام خانوادگی</th>
                                                <th class="column-title">کد پرسنلی</th>
                                                <th class="column-title">شناسه حسابداری</th>
                                                <th class="column-title">محل خدمت</th>
                                                <th class="column-title">وضعیت</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($site->users as $user)
                                                <tr class="even pointer">
                                                    <td class=" ">{{ $user->id }}</td>
                                                    <td class=" ">{{ $user->first_name }}</td>
                                                    <td class=" ">{{ $user->last_name }}</td>
                                                    <td class=" ">{{ $user->identification_code }}</td>
                                                    <td class=" ">{{ $user->accounting_code ?? "تعریف نشده" }}</td>
                                                    <td class=" ">{{ @$user->site->title }}</td>
                                                    @if($user->status == 1)
                                                        <td class="green">فعال</td>
                                                    @endif
                                                    @if($user->status == 0)
                                                        <td class="red">غیر فعال</td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
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
