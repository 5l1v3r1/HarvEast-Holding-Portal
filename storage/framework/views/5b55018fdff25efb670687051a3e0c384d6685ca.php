<?php $__env->startComponent('mail::message'); ?>
У вас новая заявка “<?php echo e($name); ?>”<br>
Отправитель: <a href="<?php echo e(config('app.url').'/users/'.$user->id); ?>"><?php echo e($user->name); ?></a>

<?php $__env->startComponent('mail::table'); ?>
|               |            |
| - | -|
<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
| <?php echo e(isset($field['label']) ? $field['label'] : '-'); ?>    | <?php echo e((!is_array($field['value']) && isset($field['value'])) ? $field['value'] : '-'); ?>|
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php echo $__env->renderComponent(); ?>
С благодарностью,<br>
<?php echo e($user->name); ?>

<?php echo $__env->renderComponent(); ?>
