<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'saldos-form',
	'enableAjaxValidation'=>false,
)); 
//obtenemos los numeros de recibos 
$recibo=Recibos::model()->findByPK($_GET['reciboId']);

?>

	
	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'Pendientes'); ?>
		<?php 
                //armamos el criterio de busqueda
                $criterio = new CDbCriteria;
                $criterio->condition='clienteId=:clienteId AND estado=:estado AND id NOT IN (SELECT notaVentaId FROM recibosNotaVenta WHERE reciboId=:reciboId)';
                $criterio->params=array(':clienteId'=>$recibo->clienteId, ':estado'=>'0',':reciboId'=>$recibo->id);
                $criterio->order="periodo,id";
                
                echo $form->dropDownList($model,'notaVentaId', CHtml::listData(NotaVenta::model()->findAll($criterio), 'id', 'detalleCompleto'), array('prompt' => 'Seleccione')); 
                
                ?>
		<?php echo $form->error($model,'notaVentaId'); ?>
	</div>
	
    <div class="row">
		<?php echo $form->labelEx($model,'Monto a Abonar'); ?>
		<?php echo $form->textField($model,'monto',array('size'=>19,'maxlength'=>19)); ?>
		<?php echo $form->error($model,'monto'); ?>
	</div>   
	
	 <div class="row">
		<?php echo $form->labelEx($model,'Recargo'); ?>
		<?php echo $form->textField($model,'recargo',array('size'=>19,'maxlength'=>19)); ?>
		<?php echo $form->error($model,'recargo'); ?>
	</div>    
	
	<div class="row">
		<?php
		echo $form->hiddenField($model,'reciboId',array('value'=>$recibo->id)); 
		?>
	</div>

	

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Agregar' : 'Guardar'); ?>
		<?php echo CHtml::Button('Cancelar',array('submit'=>array('update', 'id'=>$recibo->id))); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->