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
		<?php echo $form->label($model,'fechaPago'); ?>
		<?php echo $form->textField($model,'fechaPago'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'monto'); ?>
		<?php echo $form->textField($model,'monto',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'montoNeto'); ?>
		<?php echo $form->textField($model,'montoNeto',array('size'=>15,'maxlength'=>15)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'numeroTransaccion'); ?>
		<?php echo $form->textField($model,'numeroTransaccion',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'clienteId'); ?>
		<?php echo $form->textField($model,'clienteId'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nroPagoElectronico'); ?>
		<?php echo $form->textField($model,'nroPagoElectronico',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'estado'); ?>
		<?php echo $form->textField($model,'estado'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->