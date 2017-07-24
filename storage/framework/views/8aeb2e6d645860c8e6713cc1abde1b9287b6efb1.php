<?php $__env->startSection('content'); ?>
	<main class="main_column documentWrap">
		<div class="documentPrtSc">
			<img class="documentPrtSc_item" src="<?php if(isset($document->photo)): ?> /storage/app/public/<?php echo e($document->photo); ?> <?php else: ?> /public/elements-img/documents/example.png <?php endif; ?>" alt="example">
		</div>
		<section class="documentInfo whiteBox documentBox">
			<article>
				<div class="documentInfo_title">
					<h1><?php echo e($document->name); ?></h1>
				</div>
				<div class="documentInfo_descr">
					<p><?php echo e($document->description); ?></p>
				</div>
				<div class="documentInfo_download">
					
					<p class="btn_download">
						<a href="/storage/app/public/<?php echo e($document->link); ?>" > 
							Cкачать
						</a>
						<span>
							.<?php echo e($extension); ?>

						</span>
					</p>
					
				</div>
			</article>
		</section>
	</main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>