<?php $__env->startSection('content'); ?>
<br>
<div class="col-md-12">
	<div class="container panel panel-bordered">
		<div class="panel-body table-responsive">
			<form action="<?php echo e($url); ?>" method="POST"> 
				<?php echo e(csrf_field()); ?>

				<input type="hidden" name="role" value="<?php echo e($role->id); ?>">
				<div class="row col-md-12">
					<?php $__currentLoopData = App\City::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="row col-md-12">
						<div class="col-md-2">
							<div class="dataTables_length">
								<label><?php echo e($city->name); ?></label>
							</div>
						</div>
						<div class="col-md-10">
							<div class="dataTables_length">
							<?php $__currentLoopData = App\Department::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<div class="dataTables_length" style="display:flex;">
									<p><?php echo e($department->name); ?></p>
									<select class="form-control select2" style="width:250px" name="head[<?php echo e($city->id); ?>][<?php echo e($department->id); ?>]">
											<option value="">&nbsp;</option>						
										<?php $__currentLoopData = $users->where('city_id', $city->id)->where('department_id', $department->id)->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($user->id); ?>" <?php if($user->isRole($role->id)): ?> selected <?php endif; ?>><?php echo e($user->name); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
									<input class="form-control input-sm" type="email" style="max-width:300px;" name="email[<?php echo e($city->id); ?>][<?php echo e($department->id); ?>]" 
									<?php if($email = App\RoleDepartmentsEmail::exists($city->id, $department->id, $role->id)): ?> 
										value="<?php echo e($email); ?>"
									<?php endif; ?>>
								</div>
								<br>
							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</div>
						</div>
					<hr>
					</div>	
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				</div>
				<input type="submit" class="btn btn-success" name="submit">
			</form>
		</div>	
	</div>	
</div>	
<?php $__env->stopSection(); ?>
<?php echo $__env->make('voyager::master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>