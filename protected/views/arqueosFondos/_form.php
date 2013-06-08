<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'arqueos-fondos-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'arqueoId'); ?>
		<?php echo $form->textField($model,'arqueoId',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'arqueoId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tipoFondoId'); ?>
		<?php echo $form->textField($model,'tipoFondoId'); ?>
		<?php echo $form->error($model,'tipoFondoId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'saldo'); ?>
		<?php echo $form->textField($model,'saldo',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'saldo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'valorActual'); ?>
		<?php echo $form->textField($model,'valorActual',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'valorActual'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->