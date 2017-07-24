<?php if(isFieldTranslatable($data, $row)): ?>
    <input type="hidden"
           data-i18n="true"
           name="<?php echo e($row->field.$row->id); ?>_i18n"
           id="<?php echo e($row->field.$row->id); ?>_i18n"
           value="<?php echo e(getFieldTranslations($data, $row->field)); ?>">
<?php endif; ?>
