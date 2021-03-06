<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'instaladores-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>
           
	<div class="row">
		<?php echo $form->labelEx($model,'depositoId'); ?>
		<?php echo $form->dropDownList($model,'depositoId', CHtml::listData(Depositos::model()->findAll(array('order'=>'descripcion')), 'id', 'descripcion'), array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'depositoId'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->