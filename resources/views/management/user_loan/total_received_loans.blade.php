
@extends('master')

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>گزارش گیری</h3>
                    <h4>کل وام های دریافتی اعضا</h4>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <form action="{{ route('admin.management.user_loan.total_received_loans') }}" method="get">
                    @csrf
                    @method('get')
                    <div class="title_right">
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="جستجو بر اساس کد پرسنلی" name="search">
                                <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">برو!</button>
                    </span>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="{{ route('export.user_loan_types') }}" method="get">
                    @csrf
                    @method('get')
                    <div class="title_right">
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="جستجو بر اساس کد پرسنلی" name="identification_code">
                                <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">خروجی اکسل از کل وام های دریافتی یک عضو!</button>
                    </span>
                            </div>
                        </div>
                    </div>
                </form>
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
                                <table class="table table-striped table-bordered jambo_table bulk_action">
                                    <thead>
                                    <tr class="headings">
                                        <th class="column-title">ردیف</th>
                                        <th class="column-title">نام</th>
                                        <th class="column-title">نام خانوادگی</th>
                                        <th class="column-title">کد پرسنلی</th>
                                        @foreach($loanTypes as $loanType)
                                            <th class="column-title">{{ $loanType->title }}</th>
                                        @endforeach
                                        <th class="column-title">مجموع</th>


                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                        <tr class="even pointer ">
                                            <td class=" ">{{ $user->id }}</td>
                                            <td class=" ">{{ $user->first_name }}</td>
                                            <td class=" ">{{ $user->last_name }}</td>
                                            <td class=" ">{{ $user->identification_code }}</td>
                                            @php $horizontalTotal = 0; @endphp
                                            @foreach($loanTypes as $loanType)
                                                @php $horizontalTotal += ($user->total_received_loans)[$loanType->title] @endphp
                                                <td class="comma_numbers">{{ ($user->total_received_loans)[$loanType->title] }} </td>
                                            @endforeach
                                            <td class="comma_numbers">{{ $horizontalTotal }}</td>
                                            @php $horizontalTotal = 0; @endphp
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
