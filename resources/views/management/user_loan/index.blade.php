
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
                <form action="{{ route('admin.management.user_loan.index') }}" method="get">
                    @csrf
                    @method('get')
                    <div class="">
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="جستجو بر اساس کد پرسنلی" name="search">
                                <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">جستجو کنید!</button>
                    </span>
                            </div>
                        </div>
                    </div>
                </form>



                <form action="{{ route('export.user_loan') }}" method="get">
                    @csrf
                    @method('get')
                    <div class="">
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="جستجو بر اساس کد پرسنلی" name="identification_code">
                                <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">دریافت خروجی اکسل از وام ها و اقساط یک عضو خاص!</button>
                    </span>
                            </div>
                        </div>
                    </div>
                </form>

                <hr>

                <div class="col-sm-6">
                    <form action="{{ route('import.user_loans') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="col-md-6 col-sm-6 col-xs-6 form-group">
                            <input type="file" name="file" class="custom-file-input" id="chooseFile">
                            <label class="custom-file-label" for="chooseFile">انتخاب فایل اکسل</label>

                        </div>

                        <button type="submit" name="submit" class="btn btn-primary col-md-12 col-sm-12 col-xs-12 form-group">
                            ورود وام ها از طریق فایل اکسل
                        </button>
                    </form>

                    <a href="{{ route('admin.management.user_loan.import_status') }}">
                        <button type="submit" name="submit" class="btn btn-primary col-md-12 col-sm-12 col-xs-12 form-group">
                            بررسی وضعیت آخرین اکسل
                        </button>
                    </a>
                </div>

                <div class="col-sm-6">
                    <form action="{{ route('delete.user_loans') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('post')
                        <div class="col-md-6 col-sm-6 col-xs-6 form-group">
                            <input type="file" name="file" class="custom-file-input" id="chooseFile">
                            <label class="custom-file-label" for="chooseFile">انتخاب فایل اکسل</label>

                        </div>

                        <button type="submit" name="submit" class="btn btn-danger col-md-12 col-sm-12 col-xs-12 form-group">
                            حذف وام ها از طریق فایل اکسل
                        </button>
                    </form>

                    <a href="{{ route('admin.management.user_loan.delete_status') }}">
                        <button type="submit" name="submit" class="btn btn-danger col-md-12 col-sm-12 col-xs-12 form-group">
                            بررسی وضعیت آخرین اکسل
                        </button>
                    </a>
                </div>







            </div>

            <hr>


            <div class="clearfix"></div>
            @if (session('result'))
                <div class="alert alert-success col-md-4 col-sm-4 col-xs-4">
                        <span>
                            {{ session('result') }}
                        </span>
                </div>
            @endif

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
                                <table class="table table-striped table-bordered jambo_table bulk_action">
                                    <thead>
                                    <tr class="headings">
                                        <th class="column-title">ردیف</th>
                                        <th class="column-title">کد پرسنلی</th>
                                        <th class="column-title">شناسه حسابداری</th>
                                        <th class="column-title">نام</th>
                                        <th class="column-title">نام خانوادگی</th>
                                        <th class="column-title">وام(کد)</th>
                                        <th class="column-title">مبلغ کل وام</th>
                                        <th class="column-title">تعداد قسط</th>
                                        <th class="column-title">مبلغ هر قسط</th>
                                        <th class="column-title">تعداد اقساط باقی مانده</th>
                                        <th class="column-title">مبلغ باقی مانده از وام</th>
                                        <th class="column-title">تاریخ پرداخت وام</th>
                                        <th class="column-title">تاریخ وصول اولین قسط</th>
                                        <th class="column-title">نمایش</th>
                                        <th class="column-title">ویرایش</th>
                                        <th class="column-title">حذف</th>

                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($userLoans as $userLoan)
                                        <tr class="even pointer">
                                            <td class=" ">{{ $userLoan->id }}</td>
                                            <td class=" ">{{ $userLoan->user->identification_code }}</td>
                                            <td class=" ">{{ $userLoan->user->accounting_code ?? "تعریف نشده"}}</td>
                                            <td class=" ">{{ $userLoan->user->first_name }}</td>
                                            <td class=" ">{{ $userLoan->user->last_name }}</td>
                                            <td class=" ">{{ $userLoan->loan->title }}({{ $userLoan->loan->code }})</td>
                                            <td class=""> <span class="comma_numbers">{{ $userLoan->total_amount }}</span> </td>
                                            <td class="">{{ $userLoan->installment_count }}</td>
                                            <td class=""><span class="comma_numbers">{{ $userLoan->installment_amount }}</span> </td>
                                            <td class=""><span class="comma_numbers">{{ $userLoan->remained_installment_count }}</span> </td>
                                            <td class=""><span class="comma_numbers">{{ $userLoan->total_remained_installment_amount }}</span> </td>
                                            <td class=" ">{{(new \App\Models\TimeHelper)->georgian2jalali($userLoan->loan_paid_to_user_at) }}</td>
                                            <td class=" ">{{(new \App\Models\TimeHelper)->georgian2jalali($userLoan->first_installment_received_at) }}</td>
                                            <td class=" "><a href="{{ route('admin.management.user_loan.show', $userLoan->id) }}">نمایش</a></td>
                                            <td class=" "><a href="{{ route('admin.management.user_loan.edit', $userLoan->id) }}">ویرایش</a></td>
                                            <td>
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                        data-target=".delete-modal-{{ $userLoan->id }}">حذف
                                                </button>

                                                <div class="modal fade delete-modal-{{ $userLoan->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm">
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                                        aria-hidden="true">×</span>
                                                                </button>
                                                                <h4 class="modal-title" id="myModalLabel2">حذف وام "{{ $userLoan->user->first_name.' '. $userLoan->user->last_name }}"</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>با حذف وام تمام اطلاعات وام و اقساط مربوط به آن حذف خواهد شد. آیا اطمینان دارید؟ </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                                                                <button type="button" class="btn btn-danger">
                                                                    <a href="{{ route('admin.management.user_loan.destroy', $userLoan->id) }}" style="color: whitesmoke">
                                                                        حذف
                                                                    </a>
                                                                </button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
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
