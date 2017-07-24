<?php $info = App\Info::current() ?>
<?php if(isset($info)): ?>
	<section class="secondaryBlock">
	    <header class="headerPlace">
	        <span class="secondaryBlock_title"><?php echo e($info->name); ?></span>
	    </header>
	    <div class="secondaryBlock_box">
	        <?php echo e($info->body); ?>

	        <div class="secondaryNews_photo">
	        	<img style="width:100%" src="<?php echo e($info->photo); ?>">
	        </div>
	    </div>	    
	</section>
<?php endif; ?>