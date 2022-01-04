
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
                                        <b>شناسه حسابداری:</b> {{ $userLoan->user->accounting_code }}
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
                                        <table class="table table-striped table-bordered jambo_table bulk_action">
                                            <thead>
                                            <tr class="headings">
                                                <th class="column-title">شماره ردیف</th>
                                                <th class="column-title">مبلغ قسط</th>
                                                <th class="column-title">ماه</th>
                                                <th class="column-title">سال</th>
                                                <th class="column-title">حذف</th>
                                                <th class="column-title">ویرایش</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($installments as $installment)
                                            <tr class="even pointer">
                                                <td class=" ">{{ $installment->id }}</td>
                                                <td class=" "><span class="comma_numbers">{{ $installment->received_amount }}</span> </td>
                                                <td class=" ">{{ $installment->month }}</td>
                                                <td class=" ">{{ $installment->year }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                                            data-target=".delete-modal-{{ $installment->id }}">حذف
                                                    </button>

                                                    <div class="modal fade delete-modal-{{ $installment->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-sm">
                                                            <div class="modal-content">

                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                                            aria-hidden="true">×</span>
                                                                    </button>
                                                                    <h4 class="modal-title" id="myModalLabel2">حذف قسط</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>آیا اطمینان دارید؟ </p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                                                                    <form action="{{ route('admin.management.installments.destroy', $installment->id) }}" method="post">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button type="submit" class="btn btn-danger">
                                                                            حذف
                                                                        </button>
                                                                    </form>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.management.installments.edit', $installment->id) }}"><button class="btn btn-primary">ویرایش مبلغ قسط</button></a>
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
