<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'recibos-form',
	'enableAjaxValidation'=>false,
)); 
//obtenemos los numeros de recibos 
$documento=Documentos::model()->find("tipoDocumento='REC'");

?>

	
	<?php echo $form->errorSummary($model); ?>
    <table>
	<tr><td colspan=2>
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
	</td></tr><tr><td>
	<div class="row"> 
		<?php echo $form->labelEx($model,'sucursal'); 
		echo $form->hiddenField($model,'sucursal',array('value'=>$documento->sucursal)); 
		echo str_pad($documento->sucursal,'4',"0", STR_PAD_LEFT)?>
		
	</div>
     </td><td>
	<div class="row">
		<?php echo $form->labelEx($model,'numero'); 
		echo $form->hiddenField($model,'numero',array('value'=>$documento->ultimoNumero)); 
		echo str_pad($documento->ultimoNumero,'9',"0", STR_PAD_LEFT)?>
		
	</div>
     </td></tr><tr><td colspan=2>
	<div class="row">
		<?php echo $form->labelEx($model,'clienteId'); 
		echo $form->hiddenField($model,'clienteId',array('value'=>$_GET['clienteId'])); 
		$cliente=Clientes::model()->findByPk($_GET['clienteId']);
		echo $cliente->razonSocial;
		?>
		
	</div>
	</td></tr>
    </table>
	<div class="row">
		<?php
		echo $form->hiddenField($model,'montoTotal',array('value'=>'0.00')); 
		?>
	</div>

	

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Continuar' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->