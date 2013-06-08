<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'planes-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subida'); ?>
		<?php echo $form->textField($model,'subida'); ?>
		<?php echo $form->error($model,'subida'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'bajada'); ?>
		<?php echo $form->textField($model,'bajada'); ?>
		<?php echo $form->error($model,'bajada'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'costo'); ?>
		<?php echo $form->textField($model,'costo',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'costo'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->