<?php $__env->startSection('content'); ?>
<main class="orders main_column">
		<div class="main_title">
			<h1>Документы компании</h1>
		</div>
		<section class="docTabs">
			<article>
				<div class="tabs">
					<?php $__currentLoopData = $document_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<input id="tab<?php echo e($id+1); ?>" class="tabs_item" type="radio" name="tabs" <?php if(!$id): ?> checked <?php endif; ?> >
					    <label for="tab<?php echo e($id+1); ?>" class="tabs_label" title="Вкладка 1"><?php echo e($category->name); ?></label>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php $__currentLoopData = $document_categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>	
					    <section id="content-tab<?php echo e($id+1); ?>" class="tabs_content">
					        <div class="tabs_content-description">
								<ul class="tabsContent">
					        		<?php $__currentLoopData = $category->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<li class="tabsContent_item"><a href="/documents/<?php echo e($document->id); ?>"><?php echo e($document->name); ?></a></li>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</ul>
					        </div>
					    </section>
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
			</article>
		</section>
	</main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>