<?php $__env->startSection('content'); ?>
	<table class="create-form">
		<tr class="new-form-block">
			<td><a class="new-form-link" href="/admin/bids/create">Создать новую форму</a></td>
			<td></td>
			<td></td>
		</tr>
	
	<?php $__currentLoopData = App\Bid::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		<tr class="new-form-block">
		<?php if(isset($bid)): ?>
			<td><?php echo e($bid->name); ?> </td>
			<td><?php echo e($bid->category->name); ?></td>
			<td>
			<?php if(Voyager::can('delete_bids')): ?>
                <div class="btn-sm btn-danger pull-right delete" data-id="<?php echo e($bid->id); ?>" id="delete-<?php echo e($bid->id); ?>">
                    <i class="voyager-trash"></i> Удалить <!-- Delete -->
                </div>
            <?php endif; ?>
            <?php if(Voyager::can('edit_bids')): ?>
                <a href="/admin/bids/<?php echo e($bid->id); ?>/edit" class="btn-sm btn-primary pull-right edit">
                    <i class="voyager-edit"></i> Редактировать <!-- Edit -->
                </a>
            <?php endif; ?>
			</td>
			<div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
		        <div class="modal-dialog">
		            <div class="modal-content">
		                <div class="modal-header">
		                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
		                                aria-hidden="true">&times;</span></button>
		                    <h4 class="modal-title"><i class="voyager-trash"></i> ВЫ уврены что хотите удалить заявку?</h4>
		                </div>
		                <div class="modal-footer">
		                    <form action="/admin/bids/<?php echo e($bid->id); ?>" id="delete_form" method="POST">
		                        <?php echo e(method_field("DELETE")); ?>

		                        <?php echo e(csrf_field()); ?>

		                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
		                                 value="Да, удалить эту заявку">
		                    </form>
		                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Отмена</button>
		                </div>
		            </div><!-- /.modal-content -->
		        </div><!-- /.modal-dialog -->
		    </div><!-- /.modal -->
		<?php endif; ?>
		</tr>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
	</table>
	<style lang="css" scoped>
		.create-form {
			margin: 20px;
			width: 100%;
			background-color: #f9f9f9 !important;
			border: 1px solid #dcdcdc !important;
			padding: 1rem !important;
			border-radius: 5px !important;
			padding: 10px;
		}
		.new-form-block {
			padding:5px;
			background-color:#fff;
			margin:5px 0;
			border-bottom:1px solid #dcdcdc;
		}
		.new-form-block > td {
			padding:10px;
			font-size:15px;
			text-align:left;
		}
		.new-form-link {
			border: 1px solid #16b43b;
			padding: 5px 20px;
			text-align: center;
			color:#000;
			background-color:#fff;
		}
		.new-form-link:hover {
			background-color:#16b43b;
			color:#fff;
			border: 1px solid #16b43b;
			text-align: center;
			transition:0.3s all;
		}
	</style>
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