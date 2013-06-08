<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'clientes-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>
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
		<?php echo $form->labelEx($model,'condicionIvaId'); ?>
		<?php echo $form->dropDownList($model,'condicionIvaId', CHtml::listData(CondicionesIva::model()->findAll(), 'id', 'nombre'),array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'condicionIvaId'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'cuentaOrden'); ?>
		<?php echo $form->dropDownList($model,'cuentaOrden', array('0'=>'No','1'=>'Si')); ?>
		<?php echo $form->error($model,'cuentaOrden'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'direccion'); ?>
		<?php echo $form->textField($model,'direccion',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'direccion'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'ciudadId'); ?>
		<?php echo $form->dropDownList($model,'ciudadId', CHtml::listData(Ciudades::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'ciudadId'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'barrioId'); ?>
		<?php echo $form->dropDownList($model,'barrioId', CHtml::listData(Barrios::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'barrioId'); ?>
	</div>
	
        
	<div class="row">
		<?php echo $form->labelEx($model,'provinciaId'); ?>
		<?php echo $form->dropDownList($model,'provinciaId', CHtml::listData(Provincia::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'),array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'provinciaId'); ?>
	</div>
	

	<div class="row">
		<?php echo $form->labelEx($model,'telefono'); ?>
		<?php echo $form->textField($model,'telefono',array('size'=>80,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'telefono'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'interno'); ?>
		<?php echo $form->textField($model,'interno',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'interno'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mail'); ?>
		<?php echo $form->textField($model,'mail',array('size'=>80,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'mail'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'web'); ?>
		<?php echo $form->textField($model,'web',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'web'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'codigoPagoElectronico'); ?>
		<?php echo $form->textField($model,'codigoPagoElectronico',array('size'=>40,'maxlength'=>254)); ?>
		<?php echo $form->error($model,'codigoPagoElectronico'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'infoAdicional'); ?>
		<?php echo $form->textField($model,'infoAdicional',array('size'=>60,'maxlength'=>254)); ?>
		<?php echo $form->error($model,'infoAdicional'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cobradorId'); ?>
		<?php echo $form->dropDownList($model,'cobradorId', CHtml::listData(Cobradores::model()->findAll(), 'id', 'descripcion'),array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'cobradorId'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'notificacionesElectronicas'); ?>
		<?php echo $form->checkBox($model,'notificacionesElectronicas'); ?>
		<?php echo $form->error($model,'notificacionesElectronicas'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->