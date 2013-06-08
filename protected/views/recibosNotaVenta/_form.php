<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'recibos-nota-venta-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'reciboId'); ?>
		<?php echo $form->textField($model,'reciboId'); ?>
		<?php echo $form->error($model,'reciboId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'notaVentaId'); ?>
		<?php echo $form->textField($model,'notaVentaId'); ?>
		<?php echo $form->error($model,'notaVentaId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'monto'); ?>
		<?php echo $form->textField($model,'monto',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'monto'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->