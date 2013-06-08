<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cta-cte-empleados-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha'); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiDatePicker',
			array(
				// you must specify name or model/attribute
				'model'=>$model,
				'attribute'=>'fecha',
				'language' => 'es',
				'options' => array(
					'dateFormat'=>'yy-mm-dd',
					//'defaultDate'=>Date('d-m-Y'),
					'monthNames' => array('Enero,Febrero,Marzo,Abril,Mayo,Junio,Julio,Agosto,Septiembre,Octubre,Noviembre,Diciembre'),
					'monthNamesShort' => array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"),
					'dayNames' => array('Domingo,Lunes,Martes,Miercoles,Jueves,Viernes,Sabado'),
					'dayNamesMin' => array('Do','Lu','Ma','Mi','Ju','Vi','Sa'),
					'changeMonth' => 'true',
					'changeYear' => 'true',
					'showButtonPanel' => 'true',
					'constrainInput' => 'false',
					'duration'=>'fast',
					'showAnim' =>'fold',
				),
				'htmlOptions'=>array(
				'value'=>Date('Y-m-d'),
				'readonly'=>"readonly",
				'style'=>'height:20px;'
				)
			)
		);?>
	<?php echo $form->error($model,'fecha'); ?>
	</div>

	<?php
	echo $form->hiddenField($model,'tipoMov'); 

	?>
	<div class="row">
		<?php echo $form->labelEx($model,'empleadoId'); ?>
		<?php echo $form->dropDownList($model,'empleadoId', CHtml::listData(Empleados::model()->findAll(), 'id', 'nombreApellido'),array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'empleadoId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'conceptoId'); ?>
		<?php echo $form->dropDownList($model,'conceptoId', CHtml::listData(ConceptosEmpleados::model()->findAll(), 'id', 'nombre'),array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'conceptoId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'periodo'); ?>
		<?php echo $form->textField($model,'periodo',array('size'=>6,'maxlength'=>6)); ?>
		<?php echo $form->error($model,'periodo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'monto'); ?>
		<?php echo $form->textField($model,'monto',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'monto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->