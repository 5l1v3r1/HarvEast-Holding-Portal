<?php $__env->startSection('css'); ?>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <style type="text/css">
        .file-image-size > iframe{
            max-width: 200px !important;
            max-height: 150px !important;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_header'); ?>
    <h1 class="page-title">
        <i class="<?php echo e($dataType->icon); ?>"></i> Новости
        <?php if(Voyager::can('add_'.$dataType->name)): ?>
            <a href="<?php echo e(route('voyager.'.$dataType->slug.'.create')); ?>" class="btn btn-success">
                <i class="voyager-plus"></i> Добавить
            </a>
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
                                    <th>Название</th>
                                    <th>Содержание</th>
                                    <th>Время создания</th>
                                    <th>Обрамлена</th>
                                    <th>Прикреплена</th>
                                    <?php if(Auth::user()->role->name === 'admin'): ?>
                                        <th>Департамент</th>
                                        <th>Город</th>                                    
                                    <?php endif; ?>
                                    <th class="actions">Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            if(Auth::user()->role->name !== 'admin')
                            {
                                $dataTypeContent = $dataTypeContent->where('city_id', Auth::user()->city_id)->where('department_id', Auth::user()->department_id)->all();
                            }
                             ?>
                            <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($data->name); ?></td>
                                    <td><?php echo e(str_limit(mediaLess($data->body), 300, '...')); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($data->created_at)->format('F jS, Y h:i A')); ?></td> 
                                    <td><?php if($data->is_highlighted): ?>+<?php else: ?>-<?php endif; ?></td>
                                    <td><?php if($data->is_anchored): ?>+<?php else: ?>-<?php endif; ?></td>                             
                                    <?php if(Auth::user()->role->name === 'admin'): ?>
                                        <td><?php if(isset($data->department)): ?><?php echo e($data->department->name); ?><?php else: ?>-<?php endif; ?></td>
                                        <td><?php if(isset($data->city)): ?><?php echo e($data->city->name); ?><?php else: ?>-<?php endif; ?></td>
                                    <?php endif; ?>
                                    <td class="no-sort no-click">
                                        <?php if(haveRightsOn($data)): ?>                                    
                                            <?php if(Voyager::can('delete_'.$dataType->name)): ?>
                                                <div class="btn-sm btn-danger pull-right delete" data-id="<?php echo e($data->id); ?>" id="delete-<?php echo e($data->id); ?>">
                                                    <i class="voyager-trash"></i> <!-- Delete -->
                                                </div>
                                            <?php endif; ?>
                                            <?php if(Voyager::can('edit_'.$dataType->name)): ?>
                                                <a href="<?php echo e(route('voyager.'.$dataType->slug.'.edit', $data->id)); ?>" class="btn-sm btn-primary pull-right edit">
                                                    <i class="voyager-edit"></i> <!-- Edit -->
                                                </a>
                                            <?php endif; ?>
                                            <?php if(Voyager::can('read_'.$dataType->name)): ?>
                                                <a href="/articles/<?php echo e($data->slug); ?>" class="btn-sm btn-warning pull-right">
                                                    <i class="voyager-eye"></i> <!-- View -->
                                                </a>
                                            <?php endif; ?>
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
                    <h4 class="modal-title"><i class="voyager-trash"></i> Вы уверены, что хотите удалить эту новость?</h4>
                </div>
                <div class="modal-footer">
                    <form action="<?php echo e(route('voyager.'.$dataType->slug.'.index')); ?>" id="delete_form" method="POST">
                        <?php echo e(method_field("DELETE")); ?>

                        <?php echo e(csrf_field()); ?>

                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                                 value="Да, удалить новость.">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Отмена</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('javascript'); ?>
    <!-- DataTables -->
    <script>
        <?php if(!$dataType->server_side): ?>
            $(document).ready(function () {
                $('#dataTable').DataTable({ "order": [] });
            });
        <?php endif; ?>

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