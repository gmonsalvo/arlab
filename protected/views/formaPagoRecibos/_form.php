<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'forma-pago-recibos-form',
	'enableAjaxValidation'=>false,
)); 
//obtenemos el recibo que viene como parametro
$recibo=Recibos::model()->findByPK($_GET['reciboId']);

?>

	<p class="note">Los campos con <span class="required">*</span> son obligatorios.</p>

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
		<?php echo $form->labelEx($model,'tipoFormaPago'); ?>
		<?php
		$criteriaFondos=new CDbCriteria;
		 
		    //permisos solo karina o yo hacemos cuentas especiales
		    if (!(in_array(Yii::app()->user->model->username, array('gmonsalvo','khaure'))))
			{
			$criteriaFondos->addInCondition('id', array('1','3','6','7','8'));
			}
			$criteriaFondos->order="nombre";

		 echo $form->dropDownList($model,'tipoFormaPago', CHtml::listData(FormasPago::model()->findAll($criteriaFondos), 'id', 'nombre'),array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'tipoFormaPago'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'numeroReferencia'); ?>
		<?php echo $form->textField($model,'numeroReferencia',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'numeroReferencia'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'monto'); ?>
		<?php echo $form->textField($model,'monto',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'monto'); ?>
	</div>
    <div class="row">
		<?php echo $form->hiddenField($model,'reciboId',array('value'=>$recibo->id)); 	?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Agregar' : 'Actualizar'); ?>
		<?php echo CHtml::Button('Cancelar',array('submit'=>array('recibos/update', 'id'=>$recibo->id))); ?>
	</div>
        
	
      	<div class="row">
           <br> 
	<?php echo "<b>Total de los saldos seleccionados</b>: $".number_format($recibo->totalRecibosNotaVenta,2) 
                ?>
	</div>


<?php $this->endWidget(); ?>

</div><!-- form -->