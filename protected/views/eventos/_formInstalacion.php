<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'eventos-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model,'fecha',array('value'=>$_GET['fecha']));  ?>
	<?php echo $form->hiddenField($model,'tipoEvento',array('value'=>$_GET['tipoEvento']));  ?>
	<div class="row">
		<?php echo $form->labelEx($model,'hora'); ?>
		<?php echo $form->textField($model,'hora',array('size'=>4,'maxlength'=>4)); ?>
		<?php echo $form->error($model,'hora'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($solicitud,'cuit'); ?>
		<?php echo $form->textField($solicitud,'cuit',array('size'=>13,'maxlength'=>13)); ?>
		<?php echo $form->error($solicitud,'cuit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($solicitud,'razonSocial'); ?>
		<?php echo $form->textField($solicitud,'razonSocial',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($solicitud,'razonSocial'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($solicitud,'condidicionIvaId'); ?>
		<?php echo $form->dropDownList($solicitud,'condicionIvaId', CHtml::listData(CondicionesIva::model()->findAll(), 'id', 'nombre'),array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($solicitud,'condidicionIvaId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($solicitud,'direccion'); ?>
		<?php echo $form->textField($solicitud,'direccion',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($solicitud,'direccion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($solicitud,'barrioId'); ?>
		<?php echo $form->dropDownList($solicitud,'barrioId', CHtml::listData(Barrios::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($solicitud,'barrioId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($solicitud,'ciudadId'); ?>
		<?php echo $form->dropDownList($solicitud,'ciudadId', CHtml::listData(Ciudades::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($solicitud,'ciudadId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($solicitud,'provinciaId'); ?>
		<?php echo $form->dropDownList($solicitud,'provinciaId', CHtml::listData(Provincia::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($solicitud,'provinciaId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($solicitud,'telefono'); ?>
		<?php echo $form->textField($solicitud,'telefono',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($solicitud,'telefono'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($solicitud,'mail'); ?>
		<?php echo $form->textField($solicitud,'mail',array('size'=>60,'maxlength'=>254)); ?>
		<?php echo $form->error($solicitud,'mail'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'observaciones'); ?>
		<?php echo $form->textArea($model,'observaciones',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'observaciones'); ?>
	</div>

	

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->