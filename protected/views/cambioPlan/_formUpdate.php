<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cambio-plan-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
	<?php 
		echo $form->hiddenField($model,'servicioInternetId',array('value'=>$model->servicioInternetId)); 
		$cliente=ServiciosInternet::model()->findByPk($model->servicioInternetId);
		?>
	</div>

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
					'dateFormat'=>'yy-m-d',
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
				//'value'=>Date('Y-m-d'),
				'readonly'=>"readonly",
				'style'=>'height:20px;'
				)
			)
		);?>
		<?php echo $form->error($model,'fecha'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'accion'); ?>
		<?php echo $form->dropDownList($model,'accion',array('0'=>'UPGRADE','1'=>'DOWNGRADE'), array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'accion'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'observaciones'); ?>
		<?php echo $form->textField($model,'observaciones',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'observaciones'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'planId'); ?>
		<?php echo $form->dropDownList($model,'planId', CHtml::listData(Planes::model()->findAll(), 'id', 'descripcion'), array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'planId'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'costoServicio')."$";?>
		<?php echo $form->textField($model,'costoServicio',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'costoServicio'); ?>
	</div>

	

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->