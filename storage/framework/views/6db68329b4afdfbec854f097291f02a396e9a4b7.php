<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title>Harveast</title> 
	    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/bootstrap.min.css')); ?>">
	    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/bootstrap-theme.min.css')); ?>">
	    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/style.css')); ?>"> 
    </head>
	<body style="background-image:url(/storage/app/public/background.jpg); ">
		<div class="wrapper">
		    <?php echo $__env->make('components.nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			<div class="content">	            
		        <?php echo $__env->yieldContent('content'); ?>
			</div>
			<div class="footer">
				<div class="copyright main_column">
					<div class="copyright_item">
						<span <?php if(!Storage::disk('public')->exists('background.jpg')): ?> style="color:black !important;" <?php endif; ?> class="copyright_descr">2017 © HarvEast Holding</span>
					</div>
				</div>

				<div <?php if(!Storage::disk('public')->exists('background.jpg')): ?> style="overflow:hidden;height:80px;background:url('/public/elements-img/patterns/optimised.svg') 0 -30px repeat-x;background-size:auto 794px" <?php endif; ?> class="footer_green">
				</div>	
			</div> <!-- footer -->
		</div>
		<script src="<?php echo e(asset('js/app.js')); ?>"></script>
	</body>
</html>