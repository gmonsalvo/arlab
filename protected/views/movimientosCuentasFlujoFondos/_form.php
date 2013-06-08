<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'movimientos-stock-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>

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
					//'defaultDate'=>Date('dd-m-Y'),
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
				'style'=>'height:20px;',
			
				)
			)
		);?>
	<?php echo $form->error($model,'fecha'); ?>
       	</div>
    <div class="row">
		<?php echo $form->labelEx($model,'tipoFondoId'); ?>
		<?php
		$criteriaFondos=new CDbCriteria;
		 
		    //permisos solo karina o yo hacemos cuentas especiales
		    if (!(in_array(Yii::app()->user->model->username, array('gmonsalvo','khaure'))))
			{
			$criteriaFondos->addInCondition('id', array('1','3'));
			}
			$criteriaFondos->order="nombre";

		 echo $form->dropDownList($model,'tipoFondoId', CHtml::listData(FormasPago::model()->findAll($criteriaFondos), 'id', 'nombre'),array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'tipoFondoId'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'monto'); ?>
		<?php echo $form->textField($model,'monto',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'monto'); ?>
	</div>
        
	<?php echo $form->hiddenField($model,'cuentaOrigen',array('value'=>Yii::app()->params['cuentaCajaDiaria'])); ?>
     <?php echo $form->hiddenField($model,'cuentaDestino',array('value'=>Yii::app()->params['cuentaCajaMayor'])); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Realizar Pase'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->