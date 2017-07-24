<!-- <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default"> -->
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/style.css')); ?>"> 
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
                        <?php if(session('status')): ?>
                            <div class="alert alert-success">
                                <?php echo e(session('status')); ?>

                            </div>
                        <?php endif; ?>

                        <form class="form-horizontal loginForm" role="form" method="POST" action="<?php echo e(url('/password/reset')); ?>">
                            <?php echo e(csrf_field()); ?>


                            <input type="hidden" name="token" value="<?php echo e($token); ?>">

                            <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                                <label for="email" class="control-label">введите E-Mail</label>

                                
                                    <input id="email" type="email" class="form-control" name="email" value="<?php echo e(isset($email) ? $email : old('email')); ?>" required autofocus>

                                    <?php if($errors->has('email')): ?>
                                        <span class="help-block">
                                            <strong><?php echo e($errors->first('email')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                
                            </div>

                            <div class="form-group<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                                <label for="password" class="col-md-4 control-label">введите пароль</label>

                                
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    <?php if($errors->has('password')): ?>
                                        <span class="help-block">
                                            <strong><?php echo e($errors->first('password')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                
                            </div>

                            <div class="form-group<?php echo e($errors->has('password_confirmation') ? ' has-error' : ''); ?>">
                                <label for="password-confirm" class="col-md-4 control-label">повторите пароль</label>
                                
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                    <?php if($errors->has('password_confirmation')): ?>
                                        <span class="help-block">
                                            <strong><?php echo e($errors->first('password_confirmation')); ?></strong>
                                        </span>
                                    <?php endif; ?>
                                
                            </div>


                            <div class="form-group">
                                
                                    <button type="submit" class="auth-button btn_submitLogin">
                                        Восстановить пароль
                                    </button>
                                
                            </div>
                            <a class="readMore_button btn btn-link login_link" href="<?php echo e(url('/login')); ?>">
                                Вернутся к авторизации
                            </a>
                        </form>
                    </div>
                </section>
            </main>    
        </div>
    </div>
</body>

