<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'nota-venta-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Los Campo con <span class="required">*</span> son obligatorios.</p>

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
				'value'=>Date('d/m/Y'),
				'readonly'=>"readonly",
				'style'=>'height:20px;'
				)
			)
		);?>
		<?php echo $form->error($model,'fecha'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'detalle'); ?>
		<?php echo $form->textArea($model,'detalle',array('size'=>100,'maxlength'=>5000,'rows'=>4,'cols'=>50)); ?>
		<?php echo $form->error($model,'detalle'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'periodo'); ?>
		<?php echo $form->textField($model,'periodo')." Formato Ej. 201207"; ?>
		<?php echo $form->error($model,'periodo'); ?>
	</div>
	 <div class="row">
		<?php echo $form->labelEx($model,'fechaVencimiento'); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiDatePicker',
			array(
				// you must specify name or model/attribute
				'model'=>$model,
				'attribute'=>'fechaVencimiento',
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
				'value'=>Date('d/m/Y'),
				'readonly'=>"readonly",
				'style'=>'height:20px;'
				)
			)
		);?>
		<?php echo $form->error($model,'fechaVencimiento'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'monto')."$";?>
		<?php echo $form->textField($model,'monto',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'monto'); ?>
	</div>
        
       

	<?php 
		echo $form->hiddenField($model,'clienteId',array('value'=>$_GET['clienteId'])); 
		$cliente=Clientes::model()->findByPk($_GET['clienteId']);
		?>

	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->