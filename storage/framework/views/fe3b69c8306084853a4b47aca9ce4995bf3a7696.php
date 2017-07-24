<?php $__env->startSection('content'); ?>
	<?php echo e($bid->name); ?>

	<form method="POST" action="/bid/<?php echo e($bid->id); ?>">
		<?php echo e(csrf_field()); ?>


		<?php echo e(dd(unserialize($bid->fields))); ?>

		<textarea name="body" required></textarea>
		<input type="submit" name="submit">
	</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>