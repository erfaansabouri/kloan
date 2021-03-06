
@extends('master')

@section('content')


    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>دریافت پس انداز ماهیانه</h3>
                </div>



                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right">
                        <a href="{{ route('admin.management.users.index') }}">
                            <button class="btn btn-block btn-dark">بازگشت</button>
                        </a>
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
                            <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="post" action="{{ route('admin.management.savings.receive_from_all_users_store') }}">
                                @csrf
                                @method('post')
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">تاریخ
                                    </label>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <input type="text" id="last-name" name="month" value="" placeholder="ماه"
                                               class="form-control col-md-7 col-xs-12">
                                    </div>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <input type="text" id="last-name" name="year" value="" placeholder="سال"
                                               class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">مبلغ به
                                    </label>
                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                        <input type="text" id="last-name" name="amount" value="{{ $amount }}" placeholder="مبلغ"
                                               class="form-control col-md-7 col-xs-12">
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <button type="submit" class="btn btn-success">دریافت اقساط</button>
                                        <a href="{{ route('home') }}">
                                            <div class="btn btn-danger">انصراف</div>
                                        </a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <form action="{{ route('import.savings') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <input type="file" name="file" class="custom-file-input" id="chooseFile">
                                <label class="custom-file-label" for="chooseFile">انتخاب فایل اکسل</label>

                            </div>

                            <button type="submit" name="submit" class="btn btn-success col-md-12 col-sm-12 col-xs-12 form-group">
                                دریافت مبلغ از طریق فایل اکسل
                            </button>
                        </form>

                        <a href="{{ route('admin.management.savings.import_status') }}">
                            <button type="submit" name="submit" class="btn btn-success col-md-12 col-sm-12 col-xs-12 form-group">
                                بررسی وضعیت آخرین اکسل
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection
