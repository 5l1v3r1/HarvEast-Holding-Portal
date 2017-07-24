<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/style.css')); ?>"> 
<body>
    <div class="wrapper">
        <div class="">
            <main class="login main_column">
                <section class="loginSection news_column">
                    <div class="loginForm_logo">
                        <!-- <div class="logo_img"></div> -->
                        <img src="/public/elements-img/logo/harveast-logo-big.svg" alt="Logo">
                    </div>
                    <div class="loginForm_wrap">
                        <?php if($errors->has('password')): ?>
                            <span class="help-block">
                                <strong>Email или пароль не верны</strong>
                            </span>
                        <?php endif; ?>
                            <form class="loginForm" role="form" method="POST" action="<?php echo e(url('/login')); ?>">
                                <?php echo e(csrf_field()); ?>

                                <input id="email" type="email" class="login_item auth-input" name="email" value="<?php echo e(old('email')); ?>" placeholder="E-mail" required autofocus>
                                <input id="password" type="password" class="login_item auth-input" name="password" placeholder="Пароль" required>
                                
                                <div class="loginForm_checkbox">
                                    <!-- <?php $__currentLoopData = App\User::whereIn('role_id', [1,3,4,6])->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo e($user->role->display_name); ?> <?php echo e($user->email); ?>  - qwerty<br>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> -->
                                    <input class="checkbox_item" id="id" type="checkbox" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>> 
                                    <label class="order_checkbox" for="id">Запомнить меня на этом компьютере</label>
                                </div>
                                <div>
                                    <button type="submit" class="auth-button btn_submitLogin">
                                        Отправить
                                    </button>
                                </div>
                                <a class="readMore_button btn btn-link login_link" href="<?php echo e(url('/password/reset')); ?>">
                                    Забыли пароль?
                                </a>
                            </form>                
                        </div>                    
                </section>
            </main>
            
        </div>
        
    </div>
    
</body>

