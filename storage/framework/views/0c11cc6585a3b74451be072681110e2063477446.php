<?php $__env->startSection('content'); ?>
	<main id="userb" class="orders main_column">
		<div class="main_title">
			<h1>Оставить заявку</h1>
		</div>
			<section class="order">
			<?php $__currentLoopData = App\BidCategory::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<article class="order_article">
					<header class="header_name">
						<h2><?php echo e($category->name); ?></h2>
					</header>
					<div class="orders_column">
						<div class="column">
							<?php $__currentLoopData = $category->bids->where('published', 1)->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="order_item">
									<bid-modal :name="'<?php echo e($bid->name); ?>'" :fields="'<?php echo e($bid->fields); ?>'" <?php echo e(':csrf="'.csrf_token().'"'); ?> :id="<?php echo e($bid->id); ?>" >
										<?php echo e($bid->name); ?>

									</bid-modal>
								</div>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						</div>
					</div>
				</article>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</section>

		<?php if(session('status')): ?>
			<div v-if="showSuccess" class="orderForm_wrap">
			<section  class="successForm orderForm">
				<div @click="showSuccess = !showSuccess" class="close_icon"></div>
				<article class="successForm_content">
					<header class="successForm_header">
						<h2>Ваша заявка принята</h2>
					</header>
					<span class="successForm_descr">Менеджер свяжется с вами, ожидайте звонок.</span>
				</article>
			</section>
			</div>
		<?php endif; ?>

	</main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>