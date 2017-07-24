<?php $__env->startSection('content'); ?>
	<main class="main_column homeWrap">
		<div style="max-width: 60%" class="mainNews_wrap">
			<section class="mainNews userBox">
				<div class="user_card">
					<div class="userfoto">
						<img class="userfoto_img" src="<?php echo e($user->photo); ?>" alt="user_foto">
					</div>
					<div class="user_info">
						<div class="user_title">
							<h1><?php echo e($user->name); ?></h1>
						</div>
						<div class="user_content">
							<span class="user_post"><?php echo e(isset($user->position) ? $user->position->name : ''); ?></span>
							<span class="user_departament"><?php echo e(isset($user->department) ? $user->department->name : ''); ?></span><br>
							<div class="user_contacts">
								<div class="contacts_descr">Контакты:</div>
								<div class="contacts_descr">
									<p><?php echo e($user->city->name); ?></p>
									<p><a href="mailto:<?php echo e($user->email); ?>"><?php echo e($user->email); ?></a></p>
									<?php if($user->phones->count()): ?>
										<?php $__currentLoopData = $user->phones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						                   <p><?php echo e($phone->phone); ?></p>
						                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						            <?php endif; ?>
								</div>
								
							</div>
							<?php if(isset($user->birthday)): ?>
							<div class="user_contacts">
								<div class="contacts_descr">Дополнительно:</div>
								<div class="contacts_descr">
									<p>День рождения <?php echo e(Jdate::parse($user->birthday)->format('j F')); ?></p>					
								</div>
							</div>
							<?php endif; ?>
						</div>
						
					</div>
				</div>
			</section>
		</div>
		<aside class="sidebar"> <!-- sidebar -->
		<?php if(isset($user->department)): ?>
		<div class="asideBox">	
			<section class="secondaryBlock">
				<header class="headerPlace">
					<span class="secondaryBlock_title"><?php echo e($user->department->name); ?></span>	
				</header>
				<?php $__currentLoopData = $user->coworkers(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="secondaryBlock_box">
						<div class="userSidebar">
							<div class="staffWrap_img">	
								<img class="<?php if($user->IsHorizontalPhoto): ?> staff_img_horizontal <?php else: ?> staff_img_vertical <?php endif; ?>" src="<?php echo e($user->photo); ?>" alt="staff">
							</div>
							<div class="userSidebar_col">	
								<div class="userSidebar_title">
									<a href="/users/<?php echo e($user->id); ?>"><?php echo e($user->name); ?></a>
								</div>
								<div class="userSidebar_content">
									<span class="userSidebar_post"><?php echo e(isset($user->position) ? $user->position->name : ''); ?></span>
									<span class="userSidebar_departament"><?php echo e($user->department->name); ?></span>
									<div class="userSidebar_contacts">
										<div class="contacts_descr">
											<p><?php echo e($user->city->name); ?></p>
											<p><a href="mailto:<?php echo e($user->email); ?>"><?php echo e($user->email); ?></a></p>
							                <?php if($user->phones->count()): ?>
												<?php $__currentLoopData = $user->phones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								                   <p><?php echo e($phone->phone); ?></p>
								                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								            <?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<div class="divider"></div>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</section>
		</aside > <!-- sidebar -->
		<?php endif; ?>
	</main>			                
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>