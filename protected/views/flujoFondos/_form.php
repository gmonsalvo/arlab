<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'flujo-fondos-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',
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

	<div class="row">
		<?php echo $form->hiddenField($model,'periodo',array('value'=>$model->periodo)); ?>
		<?php echo $form->hiddenField($model,'cuentaId',array('value'=>$model->cuentaId)); ?>
		
	</div>

	<div class="row">
		<?php 
		echo $form->hiddenField($model,'tipoMov',array('value'=>$model->tipoMov)); 
		?>
	</div>
	<?php
	$criteria=new CDbCriteria;
    
       
    if ($model->tipoMov==0) //egreso
 	{
  		$criteria->compare('tipoConcepto','0');
 	}else{
 		$criteria->compare('tipoConcepto','1');
 	} 
	 $criteria->order="nombre";

	?>
	<div class="row">
		<?php echo $form->labelEx($model,'conceptoId'); ?>
		<?php 
		echo $form->dropDownList($model,'conceptoId', CHtml::listData(ConceptosFlujoFondos::model()->findAll($criteria), 'id', 'nombre'),array('prompt' => 'Seleccione')); 

		?>
		<?php echo $form->error($model,'conceptoId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'monto'); ?>
		<?php echo $form->textField($model,'monto',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'monto'); ?>
	</div>

	
	<div class="row">
		<?php echo $form->labelEx($model,'tipoFondoId'); ?>
		<?php
		$criteriaFondos=new CDbCriteria;
		 
		    //permisos solo karina o yo hacemos cuentas especiales
		    if (!(in_array(Yii::app()->user->model->username, array('gmonsalvo','khaure'))))
			{
			$criteriaFondos->addInCondition('id', array('1','3','10'));
			}
			$criteriaFondos->order="nombre";

		 echo $form->dropDownList($model,'tipoFondoId', CHtml::listData(FormasPago::model()->findAll($criteriaFondos), 'id', 'nombre'),array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'tipoFondoId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	<div class="row">
		<?php 
		echo $form->hiddenField($model,'monedaId',array('value'=>'1')); 
		?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
		<?php echo CHtml::Button('Cancelar',array('submit'=>array($retorno, 'periodo'=>$model->periodo))); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->