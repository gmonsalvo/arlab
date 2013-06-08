<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'libros-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con  <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>40,'maxlength'=>40)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tipoLibroId'); ?>
		<?php echo $form->dropDownList($model,'tipoLibroId', CHtml::listData(TipoLibros::model()->findAll(), 'id', 'nombre')); ?>
		<?php echo $form->error($model,'tipoLibroId'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
