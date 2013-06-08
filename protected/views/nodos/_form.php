<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'nodos-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ip_wan'); ?>
		<?php echo $form->textField($model,'ip_wan',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'ip_wan'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ssid'); ?>
		<?php echo $form->textField($model,'ssid',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'ssid'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'frequencia'); ?>
		<?php echo $form->dropDownList($model,'frequencia', $model->frequencias); ?>
		<?php echo $form->error($model,'frequencia'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ip_lan'); ?>
		<?php echo $form->textField($model,'ip_lan',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'ip_lan'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tipo'); ?>
		<?php echo $form->dropDownList($model,'tipo', $model->tipos); ?>
		<?php echo $form->error($model,'tipo'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
