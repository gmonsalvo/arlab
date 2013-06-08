<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	
	<div class="row">
		<?php echo $form->labelEx($model,'ciudadId'); ?>
		<?php echo $form->dropDownList($model,'ciudadId', CHtml::listData(Ciudades::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'), array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'ciudadId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'servidorId'); ?>
		<?php echo $form->dropDownList($model,'servidorId', CHtml::listData(Nodos::model()->findAll(array('condition'=>'tipo=1 or tipo=2','order'=>'nombre')), 'id', 'gatewayDescripcion'), array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'servidorID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'repetidorId'); ?>
		<?php echo $form->dropDownList($model,'repetidorId', CHtml::listData(Nodos::model()->findAll(array('condition'=>'tipo=0 or tipo=2','order'=>'ssid')), 'id', 'repetidorDescripcion'), array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'repetidorId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ip_lan'); ?>
		<?php echo $form->textField($model,'ip_lan',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ip_antena'); ?>
		<?php echo $form->textField($model,'ip_antena',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'equipoId'); ?>
		<?php echo $form->dropDownList($model,'equipoId', CHtml::listData(Equipos::model()->findAll(), 'id', 'descripcion'), array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'equipoId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'planId'); ?>
		<?php echo $form->dropDownList($model,'planId', CHtml::listData(Planes::model()->findAll(), 'id', 'descripcion'), array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'planId'); ?>
	</div>

	

	<div class="row buttons">
		<?php echo CHtml::submitButton('Filtrar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->