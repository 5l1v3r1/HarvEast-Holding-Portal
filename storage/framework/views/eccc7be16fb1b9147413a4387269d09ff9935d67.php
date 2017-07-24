<?php $__env->startSection('css'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <style>
        .nextPhone + .nextPhone {
            margin-top: 5px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_header'); ?>
    <h1 class="page-title">
        <i class="<?php echo e($dataType->icon); ?>"></i> <?php if(isset($dataTypeContent->id)): ?><?php echo e('Редактировать пользователя'); ?><?php else: ?><?php echo e('Новый пользователь'); ?><?php endif; ?>
    </h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">

                    <div class="panel-heading">
                        <h3 class="panel-title"><?php if(isset($dataTypeContent->id)): ?><?php echo e('Редактировать  пользователя'); ?><?php else: ?><?php echo e('Добавить нового пользователя'); ?><?php endif; ?></h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form"
                          action="<?php if(isset($dataTypeContent->id)): ?>/admin/users/<?php echo e($dataTypeContent->id); ?><?php else: ?> /admin/users <?php endif; ?>"
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

                            <div class="form-group">
                                <label for="name">Фамилия Имя Отчество</label>
                                <input type="text" class="form-control" name="name"
                                    placeholder="Фамилия Имя Отчество" id="name"
                                    value="<?php if(isset($dataTypeContent->name)): ?><?php echo e(old('name', $dataTypeContent->name)); ?><?php else: ?><?php echo e(old('name')); ?><?php endif; ?>">
                            </div>

                            <div class="form-group">
                                <label for="name">Email</label>
                                <input type="email" class="form-control" name="email"
                                       placeholder="Email" id="email"
                                       value="<?php if(isset($dataTypeContent->email)): ?><?php echo e(old('email', $dataTypeContent->email)); ?><?php else: ?><?php echo e(old('email')); ?><?php endif; ?>">
                            </div>

                            <div class="form-group">
                                <label for="photo">Фото</label>
                                <?php if(isset($dataTypeContent->photo) && $dataTypeContent->photo): ?>
                                    <img src="<?php echo e($dataTypeContent->photo); ?>"
                                         style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;">
                                <?php endif; ?>
                                <input type="file" name="photo">
                            </div>

                            <?php if(auth()->user()->role->name === 'admin'): ?>
                                <div class="form-group">
                                    <label for="role">Город</label>
                                    <select name="city_id" id="city" class="form-control">
                                        <?php  $cities = App\City::all();  ?>
                                        <?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($city->id); ?>" <?php if(isset($dataTypeContent) && $dataTypeContent->city_id == $city->id): ?> selected <?php endif; ?>><?php echo e($city->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="department">Департамент</label>
                                    <select name="department_id" id="department" class="form-control">
                                        <?php  $departments = App\Department::all();  ?>
                                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($department->id); ?>" <?php if(isset($dataTypeContent) && $dataTypeContent->department_id == $department->id): ?> selected <?php endif; ?>><?php echo e($department->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="role">Роль</label>
                                    <select name="role_id" id="role" class="form-control">
                                            <option value="<?php echo e(App\Role::where('name', 'user')->first()->id); ?>" selected blocked>Выберите роль</option>
                                        <?php $__currentLoopData = App\Role::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($role->id); ?>" <?php if(isset($dataTypeContent) && $dataTypeContent->role_id == $role->id): ?> selected <?php endif; ?>><?php echo e($role->display_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            <?php endif; ?>    

                            <div class="form-group">
                                <label for="role">Должность</label>
                                <select name="position_id" id="position" class="form-control">
                                    <?php $__currentLoopData = App\Position::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $position): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($position->id); ?>" <?php if(isset($dataTypeContent) && $dataTypeContent->position_id == $position->id): ?> selected <?php endif; ?>><?php echo e($position->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <?php if(isset($dataTypeContent->id)): ?>
                                <div class="form-group">
                                    <label for="phone">Телефоны</label>
                                    <?php 
                                        $phones = App\Phone::where('user_id', $dataTypeContent->id)->get();
                                     ?>
                                    <?php $__currentLoopData = $phones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $phone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <input type="phone" class="form-control nextPhone" name="phone[]"
                                            placeholder="Телефон" id="phone"
                                            value="<?php echo e($phone->phone); ?>">
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php for($i = 1; $i < (5 - $phones->count()); $i++): ?>
                                        <input type="phone" class="form-control nextPhone" name="phone[]"
                                            placeholder="Телефон" id="phone"
                                            value="">
                                    <?php endfor; ?>
                                </div>
                            <?php else: ?>
                                <div class="form-group">
                                    <label for="phone">Телефоны</label>
                                    <?php for($i = 1; $i < 5; $i++): ?>
                                        <input type="phone" class="form-control nextPhone" name="phone[]"
                                            placeholder="Телефон" id="phone"
                                            value="">
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>

                            <div class="form-group">
                                <label for="birthday">День рождения</label>
                                <input type="date" class="form-control" name="birthday"
                                    placeholder="День рождения"
                                    value="<?php if(isset($dataTypeContent->birthday)): ?><?php echo e($dataTypeContent->birthday->format('Y-m-d')); ?><?php else: ?><?php echo e(old('birthday')); ?><?php endif; ?>">
                            </div>       
                            <div class="form-group">
                                <label for="boss">Начальник</label>
                                <select name="boss_id" id="boss" class="form-control select2">
                                    <option value="0" selected>Нет начальника</option>
                                    <?php $__currentLoopData = App\User::orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $boss): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($boss->id); ?>" <?php if(isset($dataTypeContent) && $dataTypeContent->boss_id == $boss->id): ?> selected <?php endif; ?>><?php echo e($boss->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary">Сохранить</button>
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