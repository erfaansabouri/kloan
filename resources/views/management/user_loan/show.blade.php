
@extends('master')

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title  hidden-print">
                <div class="title_left">
                    <h3>نمایش اطلاعات وام پرداختی
                </h3>
                </div>
                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right">
                        <a href="{{ route('admin.management.user_loan.index') }}">
                            <button class="btn btn-block btn-dark">بازگشت</button>
                        </a>
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

                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <section class="content invoice">
                                <!-- info row -->
                                <div class="row invoice-info">
                                    <!-- /.col -->
                                    <div class="col-xs-12 col-sm-4 invoice-col">
                                        <b>شماره ردیف:</b> {{ $userLoan->id }}
                                        <br>
                                        <b>مبلغ کل وام:</b> {{ $userLoan->total_amount }} ریال
                                        <br>
                                        <b>تعداد اقساط:</b> {{ $userLoan->installment_count }}
                                        <br>
                                        <b>مبلغ هر قسط:</b> {{ $userLoan->installment_amount }} ریال
                                        <br>
                                        <b>تاریخ اولین قسط:</b> {{(new \App\Models\TimeHelper)->georgian2jalali($userLoan->first_installment_received_at) }}
                                        <br>
                                        <b>تاریخ پرداخت وام:</b> {{(new \App\Models\TimeHelper)->georgian2jalali($userLoan->loan_paid_to_user_at) }}
                                        <br>
                                        <b>نام:</b> {{ $userLoan->user->first_name }}
                                        <br>
                                        <b>نام خانوادگی:</b> {{ $userLoan->user->last_name }}
                                        <br>
                                        <b>کد پرسنلی:</b> {{ $userLoan->user->identification_code }}
                                        <br>
                                        <b>کد حسابداری:</b> {{ $userLoan->user->accounting_code }}
                                        <br>
                                        <b>محل خدمت:</b> {{ $userLoan->user->site->title }}
                                        <br>
                                        <b> وضعیت کاربر:</b> {{ $userLoan->user->status == 0 ? "فعال" : "غیر فعال"}}
                                        <br>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <br>
                                <div class="x_content">
                                    <div class="table-responsive">
                                        <table class="table table-striped jambo_table bulk_action">
                                            <thead>
                                            <tr class="headings">
                                                <th class="column-title">شماره ردیف</th>
                                                <th class="column-title">نام</th>
                                                <th class="column-title">نام خانوادگی</th>
                                                <th class="column-title">کد پرسنلی</th>
                                                <th class="column-title">کد حسابداری</th>
                                                <th class="column-title">محل خدمت</th>
                                                <th class="column-title">وضعیت</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            <tr class="even pointer">
                                                <td class=" ">1</td>
                                                <td class=" ">1</td>
                                                <td class=" ">1</td>
                                                <td class=" ">1</td>
                                                <td class=" ">1</td>
                                                <td class=" ">1</td>
                                                <td class=" ">1</td>
                                            </tr>
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
