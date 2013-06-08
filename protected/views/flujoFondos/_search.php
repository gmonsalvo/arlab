<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<table class="row">
	<tr><td>	
		<?php echo $form->labelEx($model,'PERIODO'); ?>
	</td><td>	
		<?php echo $form->dropDownList($model,'periodo',FlujoFondos::model()->obtenerPeriodos(), array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'periodo'); ?>

	</td>
	<td>
     <?php echo $form->hiddenField($model,'cuentaId',array('value'=>$model->cuentaId)); ?>

	
		<?php echo CHtml::submitButton('Filtrar'); ?>
	</td>	
	<td> </td>
	<td> </td>
	<td> </td>
	<td> </td>
	</tr>	
	</table>

<?php $this->endWidget(); ?>

</div><!-- search-form -->