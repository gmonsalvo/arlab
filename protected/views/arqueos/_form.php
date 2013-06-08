<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'arqueos-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'cuentaId'); ?>
		<?php echo $form->textField($model,'cuentaId'); ?>
		<?php echo $form->error($model,'cuentaId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'saldoTotal'); ?>
		<?php echo $form->textField($model,'saldoTotal',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'saldoTotal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'valorActualTotal'); ?>
		<?php echo $form->textField($model,'valorActualTotal',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'valorActualTotal'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'userStamp'); ?>
		<?php echo $form->textField($model,'userStamp',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'userStamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'timeStamp'); ?>
		<?php echo $form->textField($model,'timeStamp'); ?>
		<?php echo $form->error($model,'timeStamp'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->