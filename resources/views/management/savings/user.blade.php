
@extends('master')

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title  hidden-print">
                <div class="title_left">
                    <h3>موجودی حساب پس انداز یک عضو</h3>
                </div>
                <br>

            </div>
            <div class="clearfix"></div>

            <div class="row">
                <form action="{{ route('admin.management.savings.user') }}" method="get">
                    @csrf
                    @method('get')
                    <div class="title_right">
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="جستوجو بر اساس کد پرسنلی" name="search">
                                <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">برو!</button>
                    </span>
                            </div>
                        </div>
                    </div>
                </form>
                <form action="{{ route('export.user_savings') }}" method="get">
                    @csrf
                    @method('get')
                    <div class="title_right">
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group ">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="جستوجو بر اساس کد پرسنلی" name="identification_code">
                                <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">دریافت خروجی اکسل از موجودی حساب پس انداز یک عضو!</button>
                    </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>اطلاعات
                            </h2>
                            <ul class="nav navbar-right panel_toolbox hidden-print">
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
                                        <th class="column-title">شماره ردیف</th>
                                        <th class="column-title">نام</th>
                                        <th class="column-title">نام خانوادگی</th>
                                        <th class="column-title">کد پرسنلی</th>
                                        <th class="column-title">محل خدمت</th>
                                        <th class="column-title">ماه</th>
                                        <th class="column-title">سال</th>
                                        <th class="column-title">مبلغ پس انداز ماه</th>
                                        <th class="column-title">ویرایش</th>
                                        <th class="column-title">پس انداز کل</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @php $i=0; $total=0; @endphp
                                    @foreach($savings as $saving)
                                        <tr class="even pointer">
                                            <td class=" ">{{ $saving->id }}</td>
                                            <td class=" ">{{ $saving->user->first_name }}</td>
                                            <td class=" ">{{ $saving->user->last_name }}</td>
                                            <td class=" ">{{ $saving->user->identification_code }}</td>
                                            <td class=" ">{{ @$saving->user->site->title }}</td>
                                            <td class=" ">{{ @$saving->month }}</td>
                                            <td class=" ">{{ @$saving->year }}</td>
                                            <td class="comma_numbers">{{ @$saving->amount }} </td>
                                            <td class=""><a href="{{ route('admin.management.savings.edit', $saving->id) }}">ویرایش</a></td>
                                            @php $total += $saving->amount; @endphp
                                            <td class="comma_numbers">{{ $total }} </td>
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
