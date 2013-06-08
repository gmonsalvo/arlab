<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'empleadoId'); ?>
		<?php echo $form->dropDownList($model,'empleadoId', CHtml::listData(Empleados::model()->findAll(), 'id', 'nombreApellido'),array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'empleadoId'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Filtrar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->