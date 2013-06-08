<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'rendiciones-form',
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
					'dateFormat'=>'dd/mm/yy',
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

	<div class="row">
		<?php echo $form->labelEx($model,'periodoInicio'); ?>
		<?php echo $form->textField($model,'periodoInicio'); ?>
		<?php echo $form->error($model,'periodoInicio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'periodoFin'); ?>
		<?php echo $form->textField($model,'periodoFin'); ?>
		<?php echo $form->error($model,'periodoFin'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cobradorId'); ?>
		<?php echo $form->dropDownList($model,'cobradorId', CHtml::listData(Cobradores::model()->findAll(), 'id', 'descripcion'),array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'cobradorId'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Generar' : 'Guardar Cambios'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->