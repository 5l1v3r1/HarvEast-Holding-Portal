<?php $__env->startSection('page_header'); ?>
    <h1 class="page-title">
        <i class="<?php echo e($dataType->icon); ?>"></i> <?php echo e($dataType->display_name_plural); ?>

        <?php if(Voyager::can('add_'.$dataType->name)): ?>
            <span>
                <a href="<?php echo e(route('voyager.'.$dataType->slug.'.create')); ?>" class="btn btn-success">
                    <i class="voyager-plus"></i> Добавить
                </a>
            </span>
            <?php if(auth()->user()->role->name == 'admin'): ?>
                <span>
                    <a href="/admin/import-users/" class="btn">
                        <i class="voyager-plus"></i> Импорт сотрудников
                    </a>                
                </span>
            <?php endif; ?>
        <?php endif; ?>
    </h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <table id="dataTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Аватар</th>
                                    <th>Имя</th>
                                    <th>Город</th>
                                    <th>Департамент</th>
                                    <th>Должность</th>
                                    <?php if(auth()->user()->role->name === 'admin'): ?>
                                        <th>Роль</th>
                                    <?php endif; ?>
                                    <th class="actions">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                if(auth()->user()->role->name !== 'admin')
                                {
                                    $dataTypeContent = $dataTypeContent->where('city_id', auth()->user()->city_id)->where('department_id', auth()->user()->department_id)->all();
                                }
                             ?>
                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <img src="<?php echo e($data->photo); ?>" style="width:35px">
                                    </td>
                                    <td><?php echo e(ucwords($data->name)); ?></td>
                                    <td><?php echo e(isset($data->city) ? $data->city->name : '-'); ?></td>
                                    <td><?php echo e(isset($data->department) ? $data->department->name : '-'); ?></td>
                                    <td><?php echo e(isset($data->position) ? $data->position->name : '-'); ?></td>
                                    <?php if(auth()->user()->role->name === 'admin'): ?>                                    
                                        <td><?php echo e($data->role ? $data->role->display_name : ''); ?></td>
                                    <?php endif; ?>
                                    <td class="no-sort no-click" style="display: flex">
                                        <?php if(Voyager::can('edit_'.$dataType->name)): ?>
                                            <a href="<?php echo e(route('voyager.'.$dataType->slug.'.edit', $data->id)); ?>" class="btn-sm btn-primary pull-right edit">
                                                <i class="voyager-edit"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if(auth()->user()->role->name === 'admin'): ?>             
                                            <div class="btn-sm btn-warning pull-right refresh" style="cursor: pointer; margin-left: 5px" data-email="<?php echo e($data->email); ?>" data-id="<?php echo e($data->id); ?>" id="refresh-<?php echo e($data->id); ?>">
                                                <i class="voyager-refresh"></i>
                                            </div>      
                                        <?php endif; ?>
                                        <?php if(Voyager::can('delete_'.$dataType->name)): ?>
                                            <div class="btn-sm btn-danger pull-right delete" data-id="<?php echo e($data->id); ?>" id="delete-<?php echo e($data->id); ?>">
                                                <i class="voyager-trash"></i>
                                            </div>
                                        <?php endif; ?>  
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php if(isset($dataType->server_side) && $dataType->server_side): ?>
                            <div class="pull-left">
                                <div role="status" class="show-res" aria-live="polite">Showing <?php echo e($dataTypeContent->firstItem()); ?> to <?php echo e($dataTypeContent->lastItem()); ?> of <?php echo e($dataTypeContent->total()); ?> entries</div>
                            </div>
                            <div class="pull-right">
                                <?php echo e($dataTypeContent->links()); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> Вы хотите удалить этого пользователя?</h4>
                </div>
                <div class="modal-footer">
                    <form action="<?php echo e(route('voyager.'.$dataType->slug.'.index')); ?>" id="delete_form" method="POST">
                        <?php echo e(method_field("DELETE")); ?>

                        <?php echo e(csrf_field()); ?>

                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                                 value="Да, удалить этого пользователя">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Отмена</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <div class="modal modal-warning fade" tabindex="-1" id="refresh_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> Вы хотите сбросить пароль этого пользователя?</h4>
                </div>
                <div class="modal-footer">
                    <form action="<?php echo e(url('/password/email')); ?>" id="refresh_form" method="POST">
                        <?php echo e(csrf_field()); ?>

                        <input type="email" name="email" id="inputEmail" class="form-control" value="" required="required" title="">
                        <input type="submit" class="btn btn-warning pull-right delete-confirm"
                                 value="Да, сбросить пароль">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancel</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <!-- DataTables -->
    <script src="/js/jquery-fields.min.js"></script>
    <script>
        <?php if(!$dataType->server_side): ?>
            $(document).ready(function () {
                $('#dataTable').DataTable({ "order": [] });
            });
        <?php endif; ?>

        $('td').on('click', '.delete', function (e) {
            var form = $('#delete_form')[0];
            console.log(form.action, $(this).data());
            form.action = parseActionUrl(form.action, $(this).data('id'));

            $('#delete_modal').modal('show');
        });
        $('td').on('click', '.refresh', function (e) {
            var form =  $('form#refresh_form').fields();
            form.email.val($(this).data('email'));

            $('#refresh_modal').modal('show');
        });

        function parseActionUrl(action, id) {
            return action.match(/\/[0-9]+$/)
                    ? action.replace(/([0-9]+$)/, id)
                    : action + '/' + id;
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('voyager::master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>