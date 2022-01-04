
@extends('master')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>مدیریت</h3>
                    <h4>مشخصات اعضا</h4>
                </div>
            </div>
            <form action="{{ route('admin.management.users.index') }}" method="get">
                @csrf
                @method('get')
                <div class="title_right">
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="جستجو..." name="search">
                            <span class="input-group-btn">
                      <button class="btn btn-default" type="submit">برو!</button>
                    </span>
                        </div>
                    </div>
                </div>
            </form>

            @if (session('result'))
                <div class="alert alert-success">
                    {{ session('result') }}
                </div>
            @endif


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
                                <table class="table table-striped table-bordered jambo_table bulk_action">
                                    <thead>
                                    <tr class="headings">

                                        <th class="column-title">شماره ردیف</th>
                                        <th class="column-title">نام</th>
                                        <th class="column-title">نام خانوادگی</th>
                                        <th class="column-title">کد پرسنلی</th>
                                        <th class="column-title">شناسه حسابداری</th>
                                        <th class="column-title">محل خدمت</th>
                                        <th class="column-title">وضعیت</th>
                                        <th class="column-title">عملیات</th>
                                        <th class="column-title">حذف</th>
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
                                                <a href="{{ route('admin.management.users.edit', $user->id) }}">ویرایش</a></td>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger" data-toggle="modal"
                                                        data-target=".delete-modal-{{ $user->id }}">حذف
                                                </button>

                                                <div class="modal fade delete-modal-{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm">
                                                        <div class="modal-content">

                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                                        aria-hidden="true">×</span>
                                                                </button>
                                                                <h4 class="modal-title" id="myModalLabel2">حذف پرسنل "{{ $user->first_name.' '. $user->last_name }}"</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>با حذف پرسنل تمامی وام ها، اقساط و حساب پس انداز های ایشان از سامانه حذف خواهد شد. آیا اطمینان دارید؟ </p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                                                                <button type="button" class="btn btn-danger">
                                                                    <a href="{{ route('admin.management.users.destroy', $user->id) }}" style="color: whitesmoke">
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
                            {{ $users->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection
