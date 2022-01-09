
@extends('master')

@section('content')


    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>تعریف وام جدید برای پرسنل</h3>
                </div>



                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right">
                        <a href="{{ route('admin.management.user_loan.index') }}">
                            <button class="btn btn-block btn-dark">بازگشت</button>
                        </a>
                    </div>
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        @if (session('result'))
                            <div class="alert alert-success">
                                {{ session('result') }}
                            </div>
                        @endif
                        @if (session('customError'))
                            <div class="alert alert-danger">
                                {{ session('customError') }}
                            </div>
                        @endif
                        @if($errors->any())
                            {!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
                        @endif
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>مشخصات
                            </h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br/>
                            <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" action="{{ route('admin.management.user_loan.store') }}">
                                @csrf
                                @method('post')
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">کد پرسنلی
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="identification_code" required="required" name="identification_code"
                                               class="form-control col-md-7 col-xs-12"  onkeyup="myFunction()">
                                    </div>
                                </div>

                                <script>
                                    function myFunction()
                                    {
                                        var identificationCode = document.getElementById("identification_code");
                                        var userDetails = document.getElementById("user_details");
                                        identificationCode.value = identificationCode.value.toUpperCase();
                                        $.ajax({
                                            type:'GET',
                                            url:"{{ route('get_user_details') }}",
                                            data:{identification_code:identificationCode.value},
                                            success:function(data){
                                                userDetails.value = data.first_name + ' ' + data.last_name;
                                            }
                                        });
                                    }
                                </script>

                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="user_details">نام و نام خانوادگی
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="user_details" class="form-control col-md-7 col-xs-12" disabled placeholder="با پر کردن کد پرسنلی این قسمت به صورت اتوماتیک نمایش داده خواهد شد.">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12">انتخاب زیر گروه وام</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select class="form-control" name="loan_type_id">
                                            @foreach($loanTypes as $loanType)
                                                <option value="{{ $loanType->id }}">{{ $loanType->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">مبلغ کل وام
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="last-name" name="total_amount"
                                               class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">تعداد اقساط
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <input type="text" id="last-name" name="installment_count"
                                               class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">تاریخ پرداخت وام
                                    </label>
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <input min="1" max="31" type="number" id="last-name" name="loan_paid_to_user_at_day"
                                               class="form-control col-md-7 col-xs-12" placeholder="روز">
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <input min="1" max="12"  type="number" id="last-name" name="loan_paid_to_user_at_month"
                                               class="form-control col-md-7 col-xs-12" placeholder="ماه">
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <input min="1380" max="1500"  type="number" id="last-name" name="loan_paid_to_user_at_year"
                                               class="form-control col-md-7 col-xs-12" placeholder="سال">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">تاریخ وصول اولین قسط
                                    </label>

                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <input min="1" max="31" type="number" id="last-name" name="first_installment_received_at_day"
                                               class="form-control col-md-7 col-xs-12" placeholder="روز">
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <input min="1" max="12"  type="number" id="last-name" name="first_installment_received_at_month"
                                               class="form-control col-md-7 col-xs-12" placeholder="ماه">
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <input min="1380" max="1500"  type="number" id="last-name" name="first_installment_received_at_year"
                                               class="form-control col-md-7 col-xs-12" placeholder="سال">
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="submit" class="btn btn-success">ذخیره</button>
                                        <a href="{{ route('admin.management.user_loan.index') }}">
                                            <div class="btn btn-danger">انصراف</div>
                                        </a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection
