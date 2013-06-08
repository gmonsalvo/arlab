<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'dinero-mail-pagos-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'fechaPago'); ?>
		<?php echo $form->textField($model,'fechaPago'); ?>
		<?php echo $form->error($model,'fechaPago'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'monto'); ?>
		<?php echo $form->textField($model,'monto',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'monto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'montoNeto'); ?>
		<?php echo $form->textField($model,'montoNeto',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'montoNeto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'numeroTransaccion'); ?>
		<?php echo $form->textField($model,'numeroTransaccion',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'numeroTransaccion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'clienteId'); ?>
		<?php echo $form->textField($model,'clienteId'); ?>
		<?php echo $form->error($model,'clienteId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nroPagoElectronico'); ?>
		<?php echo $form->textField($model,'nroPagoElectronico',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'nroPagoElectronico'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'estado'); ?>
		<?php echo $form->textField($model,'estado'); ?>
		<?php echo $form->error($model,'estado'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->