<link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/mail.css')); ?>"> 

<?php $__env->startComponent('mail::message'); ?>
# Introduction
Ваша учетная запись успешно создана. <br>
Данные для хода в <a href="<?php echo e(config('app.url')); ?>"><?php echo e(config('app.url')); ?></a>:

Логин - <?php echo e($user->email); ?>

Пароль - <?php echo e($password); ?>


Крайне рекомендуем изменить пароль.

С уважением,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
