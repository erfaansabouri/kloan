<div class="col-md-3 left_col hidden-print">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ route('home') }}" class="site_title"><i class="fa fa-money"></i> <span>مدیریت وام</span></a>
        </div>

        <div class="clearfix"></div>

        <!-- menu profile quick info -->
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="{{ asset('images/komite.jpg') }}" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>خوش آمدید</span>
                <h2></h2>
            </div>
        </div>
        <!-- /menu profile quick info -->

        <br/>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>منو اصلی</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-home"></i> مدیریت <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="{{ route('admin.management.users.index') }}">پرسنل</a></li>
                            <li><a href="{{ route('admin.management.loan_types.index') }}">گروه وام</a></li>
                            <li><a href="{{ route('admin.management.sub_loan_types.index') }}">زیر گروه وام</a></li>
                            <li><a href="{{ route('admin.management.sites.index') }}">محل خدمت</a></li>
                            <li><a href="{{ route('admin.management.monthly_saving.edit') }}">مبلغ پس انداز ماهیانه</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-edit"></i> عملیات <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="form.html">پرداخت وام</a></li>
                            <li><a href="form_advanced.html">دریافت قسط اتوماتیک</a></li>
                            <li><a href="form_validation.html">دریافت مبلغ پس انداز ماهیانه</a></li>
                            <li><a href="form_wizards.html">بایگانی وام های تسویه شده</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-desktop"></i> گزارش گیری <span
                                class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="general_elements.html">وام و اقساط یک عضو</a></li>
                            <li><a href="media_gallery.html">کل وام های دریافتی یک عضو</a></li>
                            <li><a href="typography.html">موجودی حساب پس انداز یک عضو</a></li>
                            <li><a href="icons.html">تفاوت وام بین دو ماه متوالی</a></li>
                            <li><a href="glyphicons.html">کسورات ماهیانه</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="تنظیمات">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="تمام صفحه" onclick="toggleFullScreen();">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="قفل" class="lock_btn">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="خروج" href="login.html">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>
