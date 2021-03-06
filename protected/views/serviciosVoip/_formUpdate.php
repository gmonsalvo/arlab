<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'servicios-voip-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los campos con <span class="required">*</span> son Obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php 
		echo $form->hiddenField($model,'clienteId',array('value'=>$model->clienteId)); 
		
		?>

	<div class="row">
		<?php echo $form->labelEx($model,'fechaInstalacion'); ?>
		<?php echo $form->textField($model,'fechaInstalacion',array('size'=>15,'maxlength'=>15,'value'=>$model->fechaInstalacion,'disabled'=>'disabled')); ?>
		<?php echo $form->error($model,'fechaInstalacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'domicilio'); ?>
		<?php echo $form->textField($model,'domicilio',array('size'=>45,'maxlength'=>45,'value'=>$model->domicilio)); ?>
		<?php echo $form->error($model,'domicilio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ciudadId'); ?>
		<?php echo $form->dropDownList($model,'ciudadId', CHtml::listData(Ciudades::model()->findAll(), 'id', 'nombre')); ?>
		<?php echo $form->error($model,'ciudadId'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'barrioId'); ?>
		<?php echo $form->dropDownList($model,'barrioId', CHtml::listData(Barrios::model()->findAll(), 'id', 'nombre')); ?>
		<?php echo $form->error($model,'barrioId'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'cicloId'); ?>
		<?php echo $form->dropDownList($model,'cicloId', CHtml::listData(Ciclos::model()->findAll(), 'id', 'descripcion')); ?>
		<?php echo $form->error($model,'cicloId'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'costoServicio'); ?>
		<?php echo $form->textField($model,'costoServicio',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'costoServicio'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'minutosLibres'); ?>
		<?php echo $form->textField($model,'minutosLibres',array('size'=>5,'maxlength'=>5)); ?>
		<?php echo $form->error($model,'minutosLibres'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'interno'); ?>
		<?php echo $form->textField($model,'interno',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'interno'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'did'); ?>
		<?php echo $form->textField($model,'did',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'did'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sipServer'); ?>
		<?php echo $form->textField($model,'sipServer',array('size'=>45,'maxlength'=>45,'value'=>'192.168.1.5')); ?>
		<?php echo $form->error($model,'sipServer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'detalleEquipo'); ?>
		<?php echo $form->textField($model,'detalleEquipo',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'detalleEquipo'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'instaladores'); ?>
		<?php echo $form->textField($model,'instaladores',array('size'=>40,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'instaladores'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->