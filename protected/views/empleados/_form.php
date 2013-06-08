<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'empleados-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombreApellido'); ?>
		<?php echo $form->textField($model,'nombreApellido',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'nombreApellido'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fechaAlta'); ?>
		<?php echo $form->textField($model,'fechaAlta'); ?>
		<?php echo $form->error($model,'fechaAlta'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sueldoActual'); ?>
		<?php echo $form->textField($model,'sueldoActual',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'sueldoActual'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'montoPrestamo'); ?>
		<?php echo $form->textField($model,'montoPrestamo',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'montoPrestamo'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->