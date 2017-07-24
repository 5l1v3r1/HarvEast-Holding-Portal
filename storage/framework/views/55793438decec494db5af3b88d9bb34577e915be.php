<?php $__env->startSection('content'); ?>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div>
                            <form action="/admin/import-users" method="POST" role="form" enctype="multipart/form-data">
                                <legend>Импорт Сотрудников</legend>

                                <?php echo e(csrf_field()); ?>

                            
                                <div class="form-group">
                                    <label for="users">Загрузите список сотрудников (.сsv)</label>
                                    <input type="file" name="users" accept=".csv" v-model="users" required="required" >
                                </div>

                                <div class="form-group">
                                    <label for="photos">Загрузите фотографии сотрудников</label>
                                    <input type="file" name="photos" v-model="photos" accept=".zip" >
                                </div>   

                                <button type="submit" class="btn btn-primary">Загрузить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('voyager::master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>