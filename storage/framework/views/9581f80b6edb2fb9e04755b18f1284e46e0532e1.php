<?php 
    $bdays = App\User::todayBirthdays();
    $bmonths = App\User::monthBirthdays();
 ?>
<?php if($bdays->count() || $bmonths->count()): ?>
    <section class="secondaryBlock">
        <header class="headerPlace">
            <span class="secondaryBlock_title">Дни рождения</span>
        </header>
        <div class="secondaryBlock_columns">    
    	    <?php if($bdays->count()): ?> 
    	        <div class="secondaryBlock_box secondaryBlock_column1 <?php if($bdays->count()): ?> `Wrap <?php endif; ?>">
    	            <span class="birthday_title">Сегодня, <?php echo e(\Jdate::now()->format('j F')); ?></span>
    	            <?php $__currentLoopData = $bdays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        	            <div class="staff">
                        <div class="staffWrap_img">
                            <img class="<?php if($user->isHorisontalPhoto): ?> staff_img_horizontal <?php else: ?> staff_img_vertical <?php endif; ?>" src="<?php echo e($user->photo); ?>" alt="staff">                        
                        </div>
        	                <div class="staff_col">
        	                    <span class="staff_name">
        							<a href="/users/<?php echo e($user->id); ?>" class="staff_nameLink"><?php echo e($user->name); ?></a>
        						</span>
        	                </div>
        	            </div>
        	         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    	        </div>
    	    <?php endif; ?>
            <div class="secondaryBlock_box secondaryBlock_column2 <?php if($bdays->count()): ?> birthWrap <?php endif; ?>"> 
                <span class="birthday_title">Именинники месяца</span>
    			<?php $__currentLoopData = $bmonths; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>            
    	            <div class="staff <?php if(!$bdays->count()): ?> staff_noBirthday <?php endif; ?>">
                        <div class="staffWrap_img">
                            <img class="<?php if($user->isHorisontalPhoto): ?> staff_img_horizontal <?php else: ?> staff_img_vertical <?php endif; ?>" src="<?php echo e($user->photo); ?>" alt="staff">                        
                        </div>
    	                <div class="staff_col">
    	                    <span class="staff_name">
    							<a href="/users/<?php echo e($user->id); ?>" class="staff_nameLink"><?php echo e($user->name); ?></a>  
    						</span>
    	                    <span class="staff_Info">
    							<?php echo e(\Jdate::parse($user->birthday)->format('j F')); ?>

    						</span>
    	                </div>
    	            </div>
    	        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                           
            </div>
        </div>
    </section>
<?php endif; ?>