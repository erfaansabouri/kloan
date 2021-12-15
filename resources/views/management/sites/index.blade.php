
@extends('master')

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>مدیریت
                        <small>لیست محل خدمت</small>
                    </h3>
                </div>
            </div>
            <form action="{{ route('admin.management.sites.index') }}" method="get">
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
                            <a href="{{ route('admin.management.sites.create') }}">
                                <div class="btn bg-green">ایجاد محل خدمت جدید</div>
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
                                        <th class="column-title">تعداد پرسنل</th>
                                        <th class="column-title">عملیات</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($sites as $site)
                                        <tr class="even pointer">
                                            <td class=" ">{{ $site->id }}</td>
                                            <td class=" ">{{ $site->title }}</td>
                                            <td class=" ">{{ $site->code ?? "فاقد کد" }}</td>
                                            <td class=" ">{{ $site->users_count }}</td>
                                            <td class=" "><a href="{{ route('admin.management.sites.show', $site->id) }}">نمایش</a> |
                                                <a href="{{ route('admin.management.sites.edit', $site->id) }}">ویرایش</a> | حذف</td>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $sites->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection
