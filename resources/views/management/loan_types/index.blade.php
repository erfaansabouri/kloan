
@extends('master')

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>مدیریت
                        <small>لیست نوع وام</small>
                    </h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <a href="{{ route('admin.management.loan_types.create') }}">
                                <div class="btn bg-green">ایجاد وام جدید</div>
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
                                        <th class="column-title">شماره ردیف</th>
                                        <th class="column-title">عنوان</th>
                                        <th class="column-title">کد</th>
                                        <th class="column-title">تعداد زیر گروه</th>
                                        <th class="column-title">عملیات</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($loanTypes as $loanType)
                                        <tr class="even pointer">
                                            <td class=" ">{{ $loanType->id }}</td>
                                            <td class=" ">{{ $loanType->title }}</td>
                                            <td class=" ">{{ $loanType->code ?? "فاقد کد" }}</td>
                                            <td class=" ">{{ $loanType->children_count }}</td>
                                            <td class=" ">
                                                <a href="{{ route('admin.management.loan_types.edit', $loanType->id) }}">ویرایش</a> | حذف</td>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $loanTypes->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection
