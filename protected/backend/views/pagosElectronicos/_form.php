<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pagos-electronicos-form',
	'enableAjaxValidation'=>false,
)); 

$cliente=Clientes::model()->findByPk(Yii::app()->user->model->username);


?>
	<div class="row">
		<?php echo "<b>Saldo Actual:</b> $".number_format($cliente->getSaldo(),2); ?>
	</br>	
	</div>	

	<?php 
	echo $form->errorSummary($model); 
	echo $form->hiddenField($model,'fecha',array('value'=>date('Y/m/d'))); 
	echo $form->hiddenField($model,'clienteId',array('value'=>Yii::app()->user->model->username)); 
	echo $form->hiddenField($model,'procesadorPago',array('value'=>'DineroMail')); 
	?>
	<div class="row">
		<?php echo $form->labelEx($model,'monto'); ?>
		<?php echo $form->textField($model,'monto',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'monto'); ?>
	</div>
	<?php
	echo $form->hiddenField($model,'estado',array('value'=>'0')); 
	?>
	
	


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Realizar Pago' : 'Realizar Pago'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->