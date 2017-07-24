<?php $__env->startSection('content'); ?>
	<div id="crebid" class="crebidclass">
	  	<form action="/admin/bids" method="POST" enctype="multipart/form-data">
	  		<?php echo e(csrf_field()); ?>

			<div class="col-md-6 statusblock1">
					<p>Ответственный менэджер:</p>
					<select name="responsible_id" class="formtypeselect">
					<?php $__currentLoopData = App\Role::bidResponsibles(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $responsible): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			    		<option value="<?php echo e($responsible->id); ?>"> <?php echo e($responsible->display_name); ?></option>
			    	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</select>	
			</div>
			<bid-form></bid-form>
			<div class="publish-block"><input type="submit" class="publish-form" name="submit" placeholder="Опубликовать заявку"></div>
		</form>

	</div>		
	<style lang="css" scoped>
			.formtypeselect {
				margin: 0;
				border: 2px solid #e4eaec;
				border-radius: 5px;
				padding: 0.3rem;
				width: 50%;
			}
			.statusblock1 {
				padding: 1rem 4rem;
			}
			.crebidclass {
				padding:2rem;
			}
			.publish-form {
				display: block;
				margin: 0 auto;
				text-align: center;
				padding: 0.5rem 1rem;
				background-color: #16b43b;
				color: #fff;
				border: 2px solid #16b43b;
			}
			@media  screen and (max-width:767px) {
				.crebidclass {
					padding:0;
				}
				.statusblock1 {
					padding: 1rem 1rem;
				}
			}
	</style>
	<script src="<?php echo e(asset('js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('voyager::master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>