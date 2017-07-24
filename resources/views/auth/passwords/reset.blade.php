<!-- <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default"> -->
<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}"> 
<body>
    <div class="wrapper">
        <div class="login_background">
            <main class="login main_column">
                <section class="loginSection news_column">
                        <div class="loginForm_logo">
                            <!-- <div class="logo_img"></div> -->
                            <img src="/public/elements-img/logo/harveast-logo-big.svg" alt="Logo">
                        </div>
                        <div class="loginForm_wrap">

                <!-- <div class="panel-heading">Reset Password</div>
                
                <div class="panel-body"> -->
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form class="form-horizontal loginForm" role="form" method="POST" action="{{ url('/password/reset') }}">
                            {{ csrf_field() }}

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="control-label">введите E-Mail</label>

                                
                                    <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">введите пароль</label>

                                
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-4 control-label">повторите пароль</label>
                                
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                
                            </div>


                            <div class="form-group">
                                
                                    <button type="submit" class="auth-button btn_submitLogin">
                                        Восстановить пароль
                                    </button>
                                
                            </div>
                            <a class="readMore_button btn btn-link login_link" href="{{ url('/login') }}">
                                Вернутся к авторизации
                            </a>
                        </form>
                    </div>
                </section>
            </main>    
        </div>
    </div>
</body>

