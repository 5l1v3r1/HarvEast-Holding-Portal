<?php $__env->startSection('css'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_header'); ?>
    <h1 class="page-title">
        <i class="<?php echo e($dataType->icon); ?>"></i> <?php if(isset($dataTypeContent->id)): ?><?php echo e('Редактировать'); ?><?php else: ?><?php echo e('Новый'); ?><?php endif; ?> <?php echo e($dataType->display_name_singular); ?>

    </h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">

                    <div class="panel-heading">
                        <h3 class="panel-title"><?php if(isset($dataTypeContent->id)): ?><?php echo e('Редактировать'); ?><?php else: ?><?php echo e('Добавить новый'); ?><?php endif; ?> <?php echo e($dataType->display_name_singular); ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form"
                          action="<?php if(isset($dataTypeContent->id)): ?> /admin/polls/<?php echo e($dataTypeContent->id); ?> <?php else: ?> /admin/polls <?php endif; ?>"
                          method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                        <?php if(isset($dataTypeContent->id)): ?>
                            <?php echo e(method_field("PUT")); ?>

                        <?php endif; ?>

                        <!-- CSRF TOKEN -->
                        <?php echo e(csrf_field()); ?>


                        <div class="panel-body">

                            <?php if(count($errors) > 0): ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <div id="poll-form">
                                <poll-form></poll-form>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="start">Время начала опроса:</label>
                                    <input type="datetime" class="form-control datepicker" name="start" value="<?php if(isset($dataTypeContent->start)): ?><?php echo e($dataTypeContent->start->format('m/d/Y g:i A')); ?><?php else: ?><?php echo e(old('start')); ?><?php endif; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="end">Время окончания опроса:</label>
                                    <input type="datetime" class="form-control datepicker" name="end" value="<?php if(isset($dataTypeContent->end)): ?><?php echo e($dataTypeContent->end->format('m/d/Y g:i A')); ?><?php else: ?><?php echo e(old('end')); ?><?php endif; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary">Добавить</button>
                        </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="<?php echo e(route('voyager.upload')); ?>" target="form_target" method="post"
                          enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        <input name="image" id="upload_file" type="file"
                               onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="<?php echo e($dataType->slug); ?>">
                        <?php echo e(csrf_field()); ?>

                    </form>

                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('voyager::master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>