<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'solicitudes-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha'); ?>
		<?php echo $form->textField($model,'fecha'); ?>
		<?php echo $form->error($model,'fecha'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cuit'); ?>
		<?php echo $form->textField($model,'cuit',array('size'=>13,'maxlength'=>13)); ?>
		<?php echo $form->error($model,'cuit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'razonSocial'); ?>
		<?php echo $form->textField($model,'razonSocial',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'razonSocial'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'condidicionIvaId'); ?>
		<?php echo $form->textField($model,'condidicionIvaId'); ?>
		<?php echo $form->error($model,'condidicionIvaId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'direccion'); ?>
		<?php echo $form->textField($model,'direccion',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'direccion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'barrioId'); ?>
		<?php echo $form->textField($model,'barrioId'); ?>
		<?php echo $form->error($model,'barrioId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ciudadId'); ?>
		<?php echo $form->textField($model,'ciudadId'); ?>
		<?php echo $form->error($model,'ciudadId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'provinciaId'); ?>
		<?php echo $form->textField($model,'provinciaId'); ?>
		<?php echo $form->error($model,'provinciaId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'usuario'); ?>
		<?php echo $form->textField($model,'usuario',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'usuario'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'telefono'); ?>
		<?php echo $form->textField($model,'telefono',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'telefono'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mail'); ?>
		<?php echo $form->textField($model,'mail',array('size'=>60,'maxlength'=>254)); ?>
		<?php echo $form->error($model,'mail'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'infoAdicional'); ?>
		<?php echo $form->textArea($model,'infoAdicional',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'infoAdicional'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'userStamp'); ?>
		<?php echo $form->textField($model,'userStamp',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'userStamp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'timeStamp'); ?>
		<?php echo $form->textField($model,'timeStamp'); ?>
		<?php echo $form->error($model,'timeStamp'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->