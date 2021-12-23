
@extends('master')

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>گزارش گیری</h3>
                    <h4>تفاوت وام بین دو ماه متوالی</h4>
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
                        <form action="{{ route('export.two_month') }}" method="get">
                            @csrf
                            @method('get')
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">تاریخ اول
                                </label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" id="first-name" required="required" name="first_month" placeholder="ماه اول"
                                           class="form-control col-md-7 col-xs-12">
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" id="first-name" required="required" name="first_year" placeholder="سال اول"
                                           class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="clearfix"></div>
                            <div class="clearfix"></div>
                            <br>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">تاریخ دوم
                                </label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" id="first-name" required="required" name="second_month" placeholder="ماه دوم"
                                           class="form-control col-md-7 col-xs-12">
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" id="first-name" required="required" name="second_year" placeholder="سال دوم"
                                           class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <br>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <button class="btn btn-success  col-md-12 col-xs-12">پردازش</button>
                            </div>
                        </form>

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
                                    <th class="column-title">تاریخ اول @if($firstMonth) {{ $firstYear }}/{{ $firstMonth }} @endif</th>
                                    <th class="column-title">تاریخ دوم @if($firstMonth) {{ $secondYear }}/{{ $secondMonth }} @endif</th>
                                    <th class="column-title">اختلاف بین دو ماه</th>


                                </tr>
                                </thead>

                                <tbody>
                                @php $totalFirstDate = 0; $totalSecondDate = 0; $total = 0;@endphp
                                @foreach($users as $user)
                                    <tr class="even pointer">
                                        <td class=" ">{{ $user->id }}</td>
                                        <td class=" ">{{ $user->first_name }}</td>
                                        <td class=" ">{{ $user->last_name }}</td>
                                        <td class=" ">{{ $user->identification_code }}</td>
                                        <td class="comma_numbers">{{ $user->total_first_date }} </td>
                                        @php $totalFirstDate += $user->total_first_date @endphp
                                        <td class="comma_numbers">{{ $user->total_second_date }} </td>
                                        @php $totalSecondDate += $user->total_second_date @endphp
                                        <td class="comma_numbers @if($user->total_first_date - $user->total_second_date < 0) red @endif @if($user->total_first_date - $user->total_second_date >= 0) green @endif">{{ $user->total_first_date - $user->total_second_date }} </td>
                                        @php $total+= $user->total_first_date - $user->total_second_date @endphp
                                    </tr>
                                @endforeach
                                <tr class="even pointer">
                                    <td class=" ">-</td>
                                    <td class=" ">-</td>
                                    <td class=" ">-</td>
                                    <td class=" ">-</td>
                                    <td class="comma_numbers">{{ $totalFirstDate }} </td>
                                    <td class="comma_numbers">{{ $totalSecondDate }} </td>
                                    <td class="comma_numbers">{{ $total }} </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection
