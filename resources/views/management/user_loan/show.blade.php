
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
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    @if (session('result'))
                        <div class="alert alert-success">
                            {{ session('result') }}
                        </div>
                    @endif
                    @if($errors->any())
                        {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                    @endif
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
                                        <br>
                                        <b>مبلغ کل وام:</b> <span class="comma_numbers">{{ $userLoan->total_amount }}</span>
                                        <br>
                                        <br>
                                        <b>تعداد اقساط:</b> {{ $userLoan->installment_count }}
                                        <br>
                                        <br>
                                        <b>مبلغ هر قسط:</b> <span class="comma_numbers">{{ $userLoan->installment_amount }}</span>
                                        <br>
                                        <br>
                                        <b>تاریخ اولین قسط:</b> {{(new \App\Models\TimeHelper)->georgian2jalali($userLoan->first_installment_received_at) }}
                                        <br>
                                        <br>
                                        <b>تاریخ پرداخت وام:</b> {{(new \App\Models\TimeHelper)->georgian2jalali($userLoan->loan_paid_to_user_at) }}
                                        <br>
                                        <br>
                                        <b>کل مبلغ پرداختی تا کنون:</b> <span class="comma_numbers">{{  $userLoan->total_received_installment_amount }}</span>
                                        <br>
                                        <br>
                                        <b>کل مبلغ باقی مانده:</b> <span class="comma_numbers">{{  $userLoan->total_remained_installment_amount }}</span>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 invoice-col">
                                        <b>نام:</b> {{ $userLoan->user->first_name }}
                                        <br>
                                        <br>
                                        <b>نام خانوادگی:</b> {{ $userLoan->user->last_name }}
                                        <br>
                                        <br>
                                        <b>کد پرسنلی:</b> {{ $userLoan->user->identification_code }}
                                        <br>
                                        <br>
                                        <b>کد حسابداری:</b> {{ $userLoan->user->accounting_code }}
                                        <br>
                                        <br>
                                        <b>محل خدمت:</b> {{ $userLoan->user->site->title }}
                                        <br>
                                        <br>
                                        <b> وضعیت کاربر:</b> {{ $userLoan->user->status == 1 ? "فعال" : "غیر فعال"}}
                                        <br>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <br>

                                <div class="x_content">
                                    <div class="x_title">
                                        <h2>اقساط پرداخت شده
                                        </h2>
                                        <ul class="nav navbar-right panel_toolbox hidden-print">

                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped jambo_table bulk_action">
                                            <thead>
                                            <tr class="headings">
                                                <th class="column-title">شماره ردیف</th>
                                                <th class="column-title">مبلغ دریافتی</th>
                                                <th class="column-title">ماه</th>
                                                <th class="column-title">سال</th>
                                                <th class="column-title">عملیات</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($installments as $installment)
                                            <tr class="even pointer">
                                                <td class=" ">{{ $installment->id }}</td>
                                                <td class=" "><span class="comma_numbers">{{ $installment->received_amount }}</span> </td>
                                                <td class=" ">{{ $installment->month }}</td>
                                                <td class=" ">{{ $installment->year }}</td>
                                                <td class=" ">
                                                    <form action="{{ route('admin.management.installments.destroy', $installment->id) }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger">
                                                            حذف
                                                        </button>
                                                    </form>
                                                </td>
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
