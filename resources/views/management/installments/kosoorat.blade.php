
@extends('master')

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>گزارش گیری</h3>
                    <h4>گزارش کسورات ماهیانه</h4>
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
                        <form action="{{ route('admin.management.installments.kosoorat') }}" method="get">
                            @csrf
                            @method('get')
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">تاریخ
                                </label>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" id="first-name" required="required" name="month" placeholder="ماه "
                                           class="form-control col-md-7 col-xs-12">
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <input type="text" id="first-name" required="required" name="year" placeholder="سال "
                                           class="form-control col-md-7 col-xs-12">
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="clearfix"></div>
                            <div class="clearfix"></div>
                            <br>
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
                                    <th class="column-title">کد پرسنلی</th>
                                    <th class="column-title">شناسه حسابداری</th>
                                    <th class="column-title">نام</th>
                                    <th class="column-title">نام خانوادگی</th>
                                    <th class="column-title">محل خدمت</th>
                                    <th class="column-title">پس انداز</th>
                                    @foreach($loanTypes as $loanType)
                                        <th class="column-title">{{ $loanType->title }}</th>
                                    @endforeach
                                    <th class="column-title">جمع</th>
                                    <th class="column-title">ماه</th>
                                    <th class="column-title">سال</th>

                                </tr>
                                </thead>

                                <tbody>
                                @php $hTotal = 0; $staticHTotal = 0; $sumOfSavingVertical = 0; $dynamicColsSum = [0,0,0,0,0,0,0,0,0,0,0,0,0,0] @endphp
                                @foreach($users as $user)
                                    <tr class="even pointer">
                                        <td class=" ">{{ $user->id }}</td>
                                        <td class=" ">{{ $user->identification_code }}</td>
                                        <td class=" ">{{ $user->accounting_code }}</td>
                                        <td class=" ">{{ $user->first_name }}</td>
                                        <td class=" ">{{ $user->last_name }}</td>

                                        <td class=" ">{{ $user->site->title }}</td>
                                        <td class="comma_numbers">{{ $user->total_saving }} </td>
                                        @php $sumOfSavingVertical += $user->total_saving; @endphp
                                        @php $hTotal += $user->total_saving @endphp
                                        @php $firstCounter = 0; @endphp
                                        @foreach($loanTypes as $loanType)
                                            <td class=" comma_numbers">{{ @($user->total_installments)[$loanType->title] }} </td>
                                            @php $hTotal += @($user->total_installments)[$loanType->title] @endphp
                                            @php $dynamicColsSum[$firstCounter++] += @($user->total_installments)[$loanType->title] @endphp
                                        @endforeach
                                        <td class="comma_numbers">{{ $hTotal }} </td>
                                        <td class="comma_numbers">{{ $month }}</td>
                                        <td class="comma_numbers">{{ $year }}</td>
                                    </tr>
                                    @php $staticHTotal += $hTotal; $hTotal = 0; $firstCounter=0; @endphp
                                @endforeach
                                <tr class="even pointer">
                                    <td class=" ">-</td>
                                    <td class=" ">-</td>
                                    <td class=" ">-</td>
                                    <td class=" ">-</td>
                                    <td class=" ">-</td>
                                    <td class=" ">-</td>
                                    <td class="comma_numbers">{{ $sumOfSavingVertical }} </td>
                                    @php $counter = 0; @endphp
                                    @foreach($loanTypes as $loanType)
                                        <th class=" comma_numbers column-title">{{ $dynamicColsSum[$counter++] }} </th>
                                    @endforeach
                                    <td class="comma_numbers">{{ $staticHTotal }} </td>
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
