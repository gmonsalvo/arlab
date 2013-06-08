<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'temas-gestion-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son requeridos</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'tipoGestionId'); ?>
		<?php echo $form->dropDownList($model,'tipoGestionId', CHtml::listData(TipoGestiones::model()->findAll(), 'id', 'nombre')); ?>
		<?php echo $form->error($model,'tipoGestionId'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>254)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->