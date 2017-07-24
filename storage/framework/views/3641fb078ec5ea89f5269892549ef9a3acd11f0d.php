<?php $__env->startSection('css'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <style type="text/css">
        .file-image-size > iframe{
            max-width: 200px !important;
            max-height: 150px !important;
        }
        .newwy > img {
            max-width: 200px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">

                    <div class="panel-heading">
                        <h3 class="panel-title"><?php if(isset($dataTypeContent->id)): ?><?php echo e('Редактирование'); ?><?php else: ?><?php echo e('Добавление'); ?><?php endif; ?> <?php echo e($dataType->display_name_singular); ?></h3>
                    </div>
                    <!-- /.box-header -->
                     <?php if(count($errors) > 0): ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                    <!-- form start -->
                    <form role="form"
                          action="<?php if(isset($dataTypeContent->id)): ?>/admin/articles/<?php echo e($dataTypeContent->slug); ?><?php else: ?> /admin/articles <?php endif; ?>"
                          method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                            <?php if(isset($dataTypeContent->id)): ?>
                                <?php echo e(method_field("PUT")); ?>

                            <?php endif; ?>

                        <!-- CSRF TOKEN -->
                        <?php echo e(csrf_field()); ?>


                    <!-- ### TITLE ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="voyager-character"></i> Post Title
                                <span class="panel-desc"> Название новости</span>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <input type="text" class="form-control" name="name" placeholder="Name" value="<?php if(isset($dataTypeContent->name)): ?><?php echo e($dataTypeContent->name); ?><?php endif; ?>">
                        </div>
                    </div>

                    <!-- ### CONTENT ### -->
                    <div class="panel col-md-8" >
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-book"></i> Контент новости</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                            </div>
                        </div>
                        <textarea class="richTextBox" name="body" style="border:0px;"><?php if(isset($dataTypeContent->body)): ?><?php echo e($dataTypeContent->body); ?><?php endif; ?></textarea>
                    </div><!-- .panel -->                   
                    <div class="panel col-md-4">
                    <!-- ### DETAILS ### -->
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-book"></i> Контент новости</h3>
                            <div class="panel-actions">
                                <a class="panel-action voyager-resize-full" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="file">Главное фото</label>                                
                                <?php if(isset($dataTypeContent->media)): ?>
                                    <div class="newwy fileType file-image-size"><?php echo $dataTypeContent->media; ?></div>
                                    <input type="checkbox" name="rmfile">удалить фото                                    
                                <?php endif; ?>
                                <input type="file" name="media">
                            </div>
                            <div class="form-group">
                                <label for="is_anchored">Закрепить на главную</label>
                                <input type="checkbox" name="is_anchored" class="toggleswitch"  <?php echo (isset($dataTypeContent->is_anchored) && $dataTypeContent->is_anchored === 1) ? 'checked="checked"' : ''; ?>">
                            </div>
                            <div class="form-group">                            
                                <label for="anchored_from">Закрепить от</label>
                                <input type="datetime" class="form-control datepicker" name="anchored_from"
       value="<?php if(isset($dataTypeContent->anchored_from)): ?><?php echo e(gmdate('m/d/Y g:i A', strtotime(old('anchored_from', $dataTypeContent->anchored_from)))); ?><?php else: ?><?php echo e(old('anchored_from')); ?><?php endif; ?>">
                            </div>
                            <div class="form-group">                            
                                <label for="anchored_to">Закрепить до</label>
                                <input type="datetime" class="form-control datepicker" name="anchored_to"
       value="<?php if(isset($dataTypeContent->anchored_to)): ?><?php echo e(gmdate('m/d/Y g:i A', strtotime(old('anchored_to', $dataTypeContent->anchored_to)))); ?><?php else: ?><?php echo e(old('anchored_to')); ?><?php endif; ?>">
                            </div>
                            <div class="form-group">
                                <label for="is_highlighted">Выделить новость</label>
                                <input type="checkbox" name="is_highlighted" class="toggleswitch"  <?php echo (isset($dataTypeContent->is_highlighted) && $dataTypeContent->is_highlighted === 1) ? 'checked="checked"' : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="tags">Тэги</label>
                                <input type="text" class="form-control" name="tags" value="<?php if(isset($dataTypeContent->tags)): ?><?php echo e(implode(', ', $dataTypeContent->tags->pluck('name')->toArray())); ?><?php endif; ?>" placeholder="Вводите теги через &quot;,&quot;">
                            </div>
                            <?php if(Auth::user()->role->name === 'admin'): ?>
                                <div class="form-group">
                                    <label for="city_id">Город</label>
                                    <select class="form-control" name="city_id">
                                        <option value="0" selected>Выберите город</option> 
                                        <option value="0">Все</option>

                                        <?php $__currentLoopData = App\City::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($city->id); ?>" <?php if(isset($dataTypeContent->city_id) && $dataTypeContent->city_id === $city->id): ?><?php echo e('selected="selected"'); ?><?php endif; ?>><?php echo e($city->name); ?>

                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="department_id">Департамент</label>
                                    <select class="form-control" name="department_id">
                                        <option value="0" selected>Выберите департамент</option>
                                        <option value="0">Все</option>
                                        <?php $__currentLoopData = App\Department::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($department->id); ?>" <?php if(isset($dataTypeContent->department_id) && $dataTypeContent->department_id === $department->id): ?><?php echo e('selected="selected"'); ?><?php endif; ?>><?php echo e($department->name); ?>

                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            <?php endif; ?>
                        </div>                  
                    </div>                  

                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
        });
    </script>
    <script src="<?php echo e(config('voyager.assets_path')); ?>/lib/js/tinymce/tinymce.min.js"></script>
    <script src="<?php echo e(config('voyager.assets_path')); ?>/js/voyager_tinymce.js"></script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('voyager::master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>