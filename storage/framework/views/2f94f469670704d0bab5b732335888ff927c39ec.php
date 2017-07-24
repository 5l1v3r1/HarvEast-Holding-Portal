<?php $__env->startSection('css'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<br>
<div class="page-content container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="container panel panel-bordered">
                <div class="panel-body table-responsive">
                    <form action="/admin/infos" method="POST" enctype="multipart/form-data"> 
                        <?php echo e(csrf_field()); ?>

                        <div class="row col-md-12">
                        <?php if(Auth::user()->role->name === 'admin'): ?>
                            <?php $__currentLoopData = App\City::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="row col-md-12">
                                    <div class="col-md-12">
                                        <div class="dataTables_length">
                                            <h4><?php echo e($city->name); ?></h4>
                                        </div>
                                    </div>
                                        <?php $__currentLoopData = App\Department::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-md-2">
                                                <div class="dataTables_length">
                                                    <h6><?php echo e($department->name); ?></h6>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <div class="dataTables_length">
                                                    <label></label>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <?php 
                                                    $info = App\Info::exists($city->id, $department->id);
                                                 ?>
                                                <input type="text" class="form-control" name="title[<?php echo e($city->id); ?>][<?php echo e($department->id); ?>]" placeholder="Название блока" <?php if($info): ?> value="<?php echo e($info->name); ?>" <?php endif; ?>>
                                                <br>
                                                <textarea name="body[<?php echo e($city->id); ?>][<?php echo e($department->id); ?>]" id="input" class="form-control" rows="3">
                                                	<?php if($info): ?> <?php echo e($info->body); ?> <?php endif; ?>
                                                </textarea>
                                            	<span>Фото</span> 					                                                              
				                                <?php if(isset($info->photo)): ?>
				                                    <div class="fileType file-image-size"><img style="max-width: 150px" src="<?php echo e($info->photo); ?>"></img></div>
				                                    <input type="checkbox" name="rmfile[<?php echo e($city->id); ?>][<?php echo e($department->id); ?>]">удалить фото
				                                <?php endif; ?>
				                                <input class="form-control" type="file" name="photo[<?php echo e($city->id); ?>][<?php echo e($department->id); ?>]" accept="image/*"/>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <div class="col-md-12">
                                    <hr>
                                </div>
                            </div>  
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                        <?php else: ?>
                            <div>
                                <?php 
                                    $city_id = Auth::user()->city_id;
                                    $department_id = Auth::user()->department_id;
                                    $info = App\Info::exists($city_id, $department_id);
                                 ?>
                                <input type="text" class="form-control" name="title[<?php echo e($city_id); ?>][<?php echo e($department_id); ?>]" placeholder="TITLE" <?php if($info): ?> value="<?php echo e($info->name); ?>" <?php endif; ?>>
                                <br>
                                <textarea class="richTextBox" name="body[<?php echo e($city_id); ?>][<?php echo e($department_id); ?>]" style="border:0px;" ><?php if($info): ?> <?php echo e($info->body); ?> <?php endif; ?></textarea>
                                <span>Фото</span> 					                                                              
                                <?php if(isset($info->photo)): ?>
                                    <div class="fileType file-image-size"><img src="<?php echo e($info->photo); ?>"></img></div>
				                    <input type="checkbox" name="rmfile[<?php echo e($city->id); ?>][<?php echo e($department->id); ?>]">удалить фото

                                <?php endif; ?>
                                <input class="form-control" type="file" name="photo[<?php echo e($city_id); ?>][<?php echo e($department_id); ?>]" accept="image/*"/>
                            </div>
                        <?php endif; ?>                       
                        <input type="submit" class="btn btn-success" name="submit" value="Сохранить">
                    </form>
                </div>  
            </div>  
        </div>  
    </div>  
</div>  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
        });
    </script>    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('voyager::master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>