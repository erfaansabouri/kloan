
@extends('master')

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>مدیریت
                        <small>لیست پرسنل</small>
                    </h3>
                </div>
            </div>
            <form action="{{ route('admin.management.users.index') }}" method="get">
                @csrf
                @method('get')
                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="جست و جو..." name="search">
                            <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">برو!</button>
                    </span>
                        </div>
                    </div>
                </div>
            </form>


            <div class="clearfix"></div>

            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <a href="{{ route('admin.management.users.create') }}">
                                <div class="btn bg-green">ایجاد پرسنل جدید</div>
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
                                        <th class="column-title">نام</th>
                                        <th class="column-title">نام خانوادگی</th>
                                        <th class="column-title">کد پرسنلی</th>
                                        <th class="column-title">کد حسابداری</th>
                                        <th class="column-title">محل خدمت</th>
                                        <th class="column-title">وضعیت</th>
                                        <th class="column-title">عملیات</th>
                                        </th>
                                        <th class="bulk-actions" colspan="7">
                                            <a class="antoo" style="color:#fff; font-weight:500;">عمل همگانی ( <span
                                                    class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($users as $user)
                                        <tr class="even pointer">
                                            <td class=" ">{{ $user->id }}</td>
                                            <td class=" ">{{ $user->first_name }}</td>
                                            <td class=" ">{{ $user->last_name }}</td>
                                            <td class=" ">{{ $user->identification_code }}</td>
                                            <td class=" ">{{ $user->accounting_code ?? "تعریف نشده" }}</td>
                                            <td class=" ">{{ @$user->site->title }}</td>
                                            @if($user->status == 1)
                                                <td class="green">فعال</td>
                                            @endif
                                            @if($user->status == 0)
                                                <td class="red">غیر فعال</td>
                                            @endif
                                            <td class=" "><a href="{{ route('admin.management.users.show', $user->id) }}">نمایش</a> |
                                                <a href="{{ route('admin.management.users.edit', $user->id) }}">ویرایش</a> | حذف</td>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $users->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection
