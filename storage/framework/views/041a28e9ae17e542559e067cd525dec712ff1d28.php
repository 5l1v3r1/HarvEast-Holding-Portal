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
                        <div class="loginForm_wrap border_wrap">

                    <?php if(session('status')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>

                    <form class="form-horizontal passResetForm" role="form" method="POST" action="<?php echo e(url('/password/email')); ?>">
                        <?php echo e(csrf_field()); ?>


                        <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">

                            <div class="loginForm">
                                <input id="email" type="email" class="login_item form-control" placeholder="E-mail" name="email" value="<?php echo e(old('email')); ?>" required>

                                <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btn_submitLogin">
                                    Сбросить пароль
                                </button>
                            </div>
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

