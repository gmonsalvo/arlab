<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fechaInstalacion'); ?>
		<?php echo $form->textField($model,'fechaInstalacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'domicilio'); ?>
		<?php echo $form->textField($model,'domicilio',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ciudadId'); ?>
		<?php echo $form->textField($model,'ciudadId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'clienteId'); ?>
		<?php echo $form->textField($model,'clienteId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ciclo'); ?>
		<?php echo $form->textField($model,'ciclo'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'costoServicio'); ?>
		<?php echo $form->textField($model,'costoServicio',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'interno'); ?>
		<?php echo $form->textField($model,'interno',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'did'); ?>
		<?php echo $form->textField($model,'did',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'sipServer'); ?>
		<?php echo $form->textField($model,'sipServer',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'detalleEquipo'); ?>
		<?php echo $form->textField($model,'detalleEquipo',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'userStamp'); ?>
		<?php echo $form->textField($model,'userStamp',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'timeStamp'); ?>
		<?php echo $form->textField($model,'timeStamp'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->