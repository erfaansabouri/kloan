<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>ورود مدیریت</title>
      <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
      <link href="{{ asset('vendors/bootstrap-rtl/dist/css/bootstrap-rtl.min.css') }}" rel="stylesheet">
      <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
      <link href="{{  asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
      <link href="{{  asset('vendors/animate.css/animate.min.css') }}" rel="stylesheet">
      <link href="{{  asset('build/css/custom.css') }}" rel="stylesheet">
   </head>
   <body class="login">
      <div>
         <a class="hiddenanchor" id="signup"></a>
         <a class="hiddenanchor" id="signin"></a>
         <a class="hiddenanchor" id="reset"></a>
         <div class="login_wrapper">
            <div class="animate form login_form">
               <section class="login_content">
                  @if($errors->any())
                  {!! implode('', $errors->all('
                  <div class="alert alert-danger">:message</div>
                  ')) !!}
                  @endif
                  <form method="post" action="{{ route('login.post') }}">
                     @csrf
                     @method('post')
                     <h1>ورود به سامانه</h1>
                     <div>
                        <input name="username" type="text" class="form-control" placeholder="نام کاربری" required="" />
                     </div>
                     <div>
                        <input name="password" type="password" class="form-control" placeholder="رمز ورود" required="" />
                     </div>
                     <div>
                        <button class="btn btn-default submit" type="submit">ورود</button>
                     </div>
                     <div class="clearfix"></div>
                     <div class="separator">
                      
                        <div class="clearfix"></div>
                        <br />
                    
                     </div>
                  </form>
               </section>
            </div>
    
            <div id="rest_pass" class="animate form rest_pass_form">
               <section class="login_content">
                  <form action="index.html">
                     <h1>بازیابی رمز عبور</h1>
                     <div class="form-group has-feedback">
                        <input type="email" class="form-control" name="email" placeholder="ایمیل" />
                        <div class="form-control-feedback">
                           <i class="fa fa-envelope-o text-muted"></i>
                        </div>
                     </div>
                     <button type="submit" class="btn btn-default btn-block">بازیابی رمز عبور </button>
                     <div class="clearfix"></div>
                     <div class="separator">
                        <p class="change_link">جدید در سایت؟
                           <a href="#signup" class="to_register"> ایجاد حساب </a>
                        </p>
                        <div class="clearfix"></div>
                        <br />
                        <div>
                           <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                           <p>©1397 تمامی حقوق محفوظ. Gentelella Alela! یک قالب بوت استرپ 3. حریم خصوصی و شرایط</p>
                        </div>
                     </div>
                  </form>
               </section>
            </div>
         </div>
      </div>
   </body>
</html>