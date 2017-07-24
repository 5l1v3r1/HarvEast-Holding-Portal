<?php $__env->startSection('content'); ?>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <?php if($dismissed_users->count()): ?>
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
                                        $dismissed_users = $dismissed_users->where('city_id', auth()->user()->city_id)->where('department_id', auth()->user()->department_id)->all();
                                    }
                                 ?>
                                <?php $__currentLoopData = $dismissed_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <img src="<?php if( strpos($data->photo, 'http://') === false && strpos($data->photo, 'https://') === false): ?><?php echo e(Voyager::image( $data->photo )); ?><?php else: ?><?php echo e($data->photo); ?><?php endif; ?>" style="width:35px">
                                        </td>
                                        <td><?php echo e(ucwords($data->name)); ?></td>
                                        <td><?php echo e(isset($data->city) ? $data->city->name : '-'); ?></td>
                                        <td><?php echo e(isset($data->department) ? $data->department->name : '-'); ?></td>
                                        <td><?php echo e(isset($data->position) ? $data->position->name : '-'); ?></td>
                                        <?php if(auth()->user()->role->name === 'admin'): ?>                                    
                                            <td><?php echo e($data->role ? $data->role->display_name : ''); ?></td>
                                        <?php endif; ?>
                                        <td class="no-sort no-click">
                                                <div class="btn-sm btn-danger pull-right delete" data-id="<?php echo e($data->id); ?>" id="delete-<?php echo e($data->id); ?>">
                                                    Восстановить
                                                </div>
                                        </td>
                                    </tr>

                                    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                                aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title"><i class="voyager-trash"></i> Вы уверены, что хотите восстановить этого пользователя?</h4>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="/admin/dismissed/<?php echo e($data->id); ?>" id="delete_form" method="POST">
                                                        <?php echo e(csrf_field()); ?>

                                                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                                                                 value="Да, восстановить">
                                                    </form>
                                                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Отмена</button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <?php else: ?>
                                <p>Нет пользователей для восстановления.</p>
                            <?php endif; ?>
                        <?php if(isset($dataType->server_side) && $dataType->server_side): ?>
                            <div class="pull-left">
                                <div role="status" class="show-res" aria-live="polite">Showing <?php echo e($dismissed_users->firstItem()); ?> to <?php echo e($dismissed_users->lastItem()); ?> of <?php echo e($dismissed_users->total()); ?> entries</div>
                            </div>
                            <div class="pull-right">
                                <?php echo e($dismissed_users->links()); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <!-- DataTables -->
    <script>
        $('td').on('click', '.delete', function (e) {
            var form = $('#delete_form')[0];

            form.action = parseActionUrl(form.action, $(this).data('id'));

            $('#delete_modal').modal('show');
        });

        function parseActionUrl(action, id) {
            return action.match(/\/[0-9]+$/)
                    ? action.replace(/([0-9]+$)/, id)
                    : action + '/' + id;
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('voyager::master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>