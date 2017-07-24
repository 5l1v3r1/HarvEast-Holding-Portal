<?php if(isFieldTranslatable($dataTypeContent, $row)): ?>
    <input type="hidden"
           data-i18n="true"
           name="<?php echo e($row->field); ?>_i18n"
           id="<?php echo e($row->field); ?>_i18n"
           value="<?php echo e(getFieldTranslations($dataTypeContent, $row->field, $row->type, true)); ?>">
<?php endif; ?>
