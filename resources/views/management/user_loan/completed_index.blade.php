
@extends('master')

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>عملیات</h3>
                    <h4>لیست وام های تسویه شده</h4>
                </div>
            </div>

          


            <div class="clearfix"></div>

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
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
                                        <th class="column-title">وام(کد)</th>
                                        <th class="column-title">مبلغ کل وام</th>
                                        <th class="column-title">کل مبلغ پرداختی</th>
                                        <th class="column-title">کل تعداد اقساط پرداختی</th>
                                        <th class="column-title">مبلغ باقی مانده</th>
                                        <th class="column-title">وضعیت پرداخت اقساط</th>
                                        <th class="column-title">عملیات</th>

                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($userLoans as $userLoan)
                                        <tr class="even pointer @if($userLoan->total_remained_installment_amount == 0) bg-green @endif">
                                            <td class=" ">{{ $userLoan->id }}</td>
                                            <td class=" ">{{ $userLoan->user->first_name }}</td>
                                            <td class=" ">{{ $userLoan->user->last_name }}</td>
                                            <td class=" ">{{ $userLoan->user->identification_code }}</td>
                                            <td class=" ">{{ $userLoan->loan->title }}({{ $userLoan->loan->code }})</td>
                                            <td class=""><span class="comma_numbers">{{ $userLoan->total_amount }}</span> </td>
                                            <td class=""><span class="comma_numbers">{{ $userLoan->total_received_installment_amount }}</span> </td>
                                            <td class=""> <span class="comma_numbers">{{ $userLoan->installments->count() }}</span></td>
                                            <td class=""><span class="comma_numbers">{{ $userLoan->total_remained_installment_amount }}</span> </td>
                                            <td class="">@if($userLoan->total_remained_installment_amount == 0) پرداخت کامل @endif @if($userLoan->total_remained_installment_amount > 0) پرداخت ناقص @endif</td>
                                            <td class=" ">
                                                <form action="{{ route('admin.management.user_loan.archive', $userLoan->id) }}" method="post">
                                                    @csrf
                                                    @method('put')
                                                    <button type="submit" class="btn btn-block btn-dark">بایگانی</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection
