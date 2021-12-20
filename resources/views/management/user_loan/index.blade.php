
@extends('master')

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>عملیات</h3>
                    <h4>لیست وام های پرداختی</h4>
                </div>
            </div>
          


            <div class="clearfix"></div>

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <a href="{{ route('admin.management.user_loan.create') }}">
                                <div class="btn bg-green">تعریف وام جدید</div>
                            </a>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">
                            <div class="table-responsive">
                                <table class="table table-striped jambo_table bulk_action">
                                    <thead>
                                    <tr class="headings">
                                        <th class="column-title">ردیف</th>
                                        <th class="column-title">نام</th>
                                        <th class="column-title">نام خانوادگی</th>
                                        <th class="column-title">کد پرسنلی</th>
                                        <th class="column-title">کد حسابداری</th>
                                        <th class="column-title">وام(کد)</th>
                                        <th class="column-title">مبلغ کل وام</th>
                                        <th class="column-title">تعداد قسط</th>
                                        <th class="column-title">مبلغ هر قسط</th>
                                        <th class="column-title">تاریخ وصول اولین قسط</th>
                                        <th class="column-title">تاریخ پرداخت وام</th>
                                        <th class="column-title">عملیات</th>

                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($userLoans as $userLoan)
                                        <tr class="even pointer">
                                            <td class=" ">{{ $userLoan->id }}</td>
                                            <td class=" ">{{ $userLoan->user->first_name }}</td>
                                            <td class=" ">{{ $userLoan->user->last_name }}</td>
                                            <td class=" ">{{ $userLoan->user->identification_code }}</td>
                                            <td class=" ">{{ $userLoan->user->accounting_code ?? "تعریف نشده"}}</td>
                                            <td class=" ">{{ $userLoan->loan->title }}({{ $userLoan->loan->code }})</td>
                                            <td class=""> {{ $userLoan->total_amount }} ریال</td>
                                            <td class="">{{ $userLoan->installment_count }}</td>
                                            <td class="">{{ $userLoan->installment_amount }} ریال</td>
                                            <td class=" ">{{(new \App\Models\TimeHelper)->georgian2jalali($userLoan->first_installment_received_at) }}</td>
                                            <td class=" ">{{(new \App\Models\TimeHelper)->georgian2jalali($userLoan->loan_paid_to_user_at) }}</td>
                                            <td class=" "><a href="{{ route('admin.management.user_loan.show', $userLoan->id) }}">نمایش</a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $userLoans->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection
