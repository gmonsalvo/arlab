<h1>Agregando Observacion</h1>


<div class="form">   
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'nota-venta-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="note">Los Campo con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>


  <div class="row">
		<?php echo $form->labelEx($model,'observaciones');?>
		<?php echo $form->textField($model,'observaciones',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'observaciones'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->