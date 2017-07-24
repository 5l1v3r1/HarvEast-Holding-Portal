<?php  $poll = App\Poll::current();  ?>
<?php if(isset($poll->id)): ?>
	<?php 
		$total = isset($poll->options) ? $poll->options->sum('votes') : 0;
	 ?>

	<section class="secondaryBlock">
        <header class="headerPlace">
            <span class="secondaryBlock_title">Опрос</span>
        </header>
        <div class="secondaryBlock_box">
	        <?php if(!App\User::hasVoted()): ?>
	            <form name="opros" method="post" action="/poll">
	                <?php echo e(csrf_field()); ?>            	
	                <span class="box_title"><?php echo e($poll->name); ?>:</span>
	                <?php $__currentLoopData = $poll->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                	<div class="form_radio form_item radio_buttons">
	                		<input id="<?php echo e($id); ?>"type="radio" name="option" value="<?php echo e($option->id); ?>">
		                    <label for="<?php echo e($id); ?>"><?php echo e($option->name); ?></label>
		                    <div class="check"></div>
	                	</div>
	                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
	                <p class="btn_submit">
	                    <input type="submit" value="Отправить">
	                </p>
	            </form>
			<?php else: ?>
	            <?php $__currentLoopData = $poll->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>			
		            <!-- Diagrams-Block -->
		            <div class="poll-result">
		                <span class="poll_caption"><?php echo e($option->name); ?></span>
		                <div class="poll_wrap">
		                    <div class="diag"><?php echo e($option->votes); ?>

		                        <div style="width:<?php echo e(100 * $option->votes/ $total); ?>%" class="diag_filled"></div>
		                    </div>
		                    <div class="diag_caption"><?php echo e(100 * $option->votes/ $total); ?>%</div>
		                </div>
		            </div>
		        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<div style="color: #B4B4B4; margin: 20px 0 10px 0"><?php echo e(numOfHumans($total)); ?></div>
	            <!-- Diagrams-Block -->
	         <?php endif; ?>
    </section>
<?php endif; ?>
