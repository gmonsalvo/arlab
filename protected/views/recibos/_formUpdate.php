<!--
<script>

function calcularTotal(){
$("#Recibos_montoTotal").val(Number($("#Recibos_recargo").val())+Number($("#Recibos_montoTotal").val()));

}

function guardarRecargo(){
    //si hay alguno seleccionado
    if($('#Recibos_recargo').val()!=''){
	    $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('recibos/guardarRecargo') ?>",
            data:{'reciboId':<?php echo $model->id?>,'recargo':$('#Recibos_recargo').val()},
            dataType: 'Text',
            success:function(data){
             
            }
        });
    }
    //calcularTotal();
}

</script>

-->
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
		<?php echo $form->textField($model,'fecha',array('size'=>11,'maxlength'=>11,'readOnly'=>true)); ?>
		<?php echo $form->error($model,'fecha'); ?>
	</div>
	</td></tr><tr><td>
	<div class="row"> 
		<?php echo $form->labelEx($model,'sucursal'); 
		echo $form->hiddenField($model,'sucursal',array('value'=>$model->sucursal)); 
		echo str_pad($model->sucursal,'4',"0", STR_PAD_LEFT)?>
		
	</div>
     </td><td>
	<div class="row">
		<?php echo $form->labelEx($model,'numero'); 
		echo $form->hiddenField($model,'numero',array('value'=>$model->numero)); 
		echo str_pad($model->numero,'9',"0", STR_PAD_LEFT)?>
		
	</div>
     </td></tr><tr><td colspan=2>
	<div class="row">
		<?php echo $form->labelEx($model,'clienteId'); 
		echo $form->hiddenField($model,'clienteId',array('value'=>$model->cliente->id)); 
		echo $model->cliente->razonSocial;
		?>
		
	</div>
	</td></tr>
    </table>
	<div class="row">
		<b>Saldos Pendientes a pagar</b>
		<?php
			//print_r($model->saldos);
			$config = array();
			$dataProvider = new CArrayDataProvider($rawData=$model->RecibosNotaVenta, $config);
			$this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$dataProvider
			,'columns'=>array(
			array(        
		      'name'=>'detalle',
		      'header'=>'Detalle',
		      'value'=>'$data->NotaVenta->detalle',
		    ),
			array(        
		      'name'=>'periodo',
		      'header'=>'Periodo',
		      'value'=>'$data->NotaVenta->periodo',
		    ),
			array(        
		      'name'=>'monto',
		      'header'=>'Monto Origen',
		      'value'=>'$data->NotaVenta->monto',
		    ),
			array(        
		      'name'=>'monto',
		      'header'=>'Monto a Pagar',
		      'value'=>'$data->monto',
		    ),
			array(        
		      'name'=>'recargo',
		      'header'=>'Recargo',
		      'value'=>'$data->recargo',
		    ),
			array(
				'class'=>'CButtonColumn',
				 'template'=>'{delete}',
			     'deleteButtonUrl'=>'Yii::app()->createUrl("/recibosNotaVenta/delete", array("id"=>$data["id"]))',
			),
			)
			));
			echo CHtml::link(CHtml::encode("Agregar Saldo"), array('addSaldo', 'reciboId'=>$model->id));
			?>
			
			<?php
			
			
			?>
			
	</div>
	<div class="row"><br>
		<b>Forma de Pago</b>
		<?php
			$config = array();
			$dataProvider = new CArrayDataProvider($rawData=$model->formaPago, $config);
			$this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$dataProvider
			,'columns'=>array(
			'fecha',
			array(        
		      'name'=>'tipoFormaPago',
		      'header'=>'Tipo',
		      'value'=>'$data->DescripcionFormaPago->nombre',
		    ),
			'monto',
			array(        
		      'name'=>'numeroReferencia',
		      'header'=>'Referencia',
		      'value'=>'$data->numeroReferencia',
		    ),
			array(
				'class'=>'CButtonColumn',
				 'template'=>'{delete}',
			     'deleteButtonUrl'=>'Yii::app()->createUrl("/formaPagoRecibos/delete", array("id"=>$data["id"]))',
			),
			)
			));
			echo CHtml::link(CHtml::encode("Agregar Pago"), array('formaPagoRecibos/create', 'reciboId'=>$model->id)); 
			
			?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'montoTotal'); ?>
		<?php echo $form->textField($model,'montoTotal',array('size'=>20,'readOnly'=>'readOnly','maxlength'=>20,'value'=>$model->totalRecibosNotaVenta)); ?>
		<?php echo $form->error($model,'montoTotal'); ?>
	</div>

	

	<div class="row buttons">
		<?php 
                if ( (abs($model->totalRecibosNotaVenta-$model->totalFormaPago)<1.00) and ($model->totalRecibosNotaVenta!=0)){
                        echo CHtml::submitButton($model->isNewRecord ? 'Continuar' : 'Guardar'); 
                     }else{
                        echo CHtml::submitButton($model->isNewRecord ? 'Continuar' : 'Guardar',array('disabled'=>true));     
                 }
		echo CHtml::Button('Cancelar Recibo',array('submit'=>array('cancelar', 'id'=>$model->id)));
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->