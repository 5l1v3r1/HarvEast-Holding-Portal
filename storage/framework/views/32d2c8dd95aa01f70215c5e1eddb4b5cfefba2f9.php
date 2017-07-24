<?php $__env->startSection('content'); ?>
	<main class="home_column homeWrap">
		<div class="logoBig_wrap">
			<div class="whiteBox">
				<div class="asideNews_logo">
					<img src="/public/elements-img/logo/harveast-logo-big.svg" alt="Logo">
				</div>
			</div>
		</div>
		<div class="mainNews_wrap">
	    	<?php echo $__env->make('main.article', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	    	<?php echo $__env->make('main.poll', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	    	<?php echo $__env->make('main.birthdays', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	    </div>
	    <aside class="sidebar">
	    	<?php echo $__env->make('main.articles', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>    
	    	<?php echo $__env->make('main.info', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		</aside>
    </main>	
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>