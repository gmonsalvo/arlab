<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'gestiones-administracion-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->hiddenField($model,'clienteId',array('value'=>$_GET['clienteId'])); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tipoGestionId'); ?>
		<?php echo $form->dropDownList($model,'tipoGestionId', CHtml::listData(TipoGestiones::model()->findAll(), 'id', 'nombre')); ?>
		<?php echo $form->error($model,'tipoGestionId'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'fecha'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker', 
                        array(
                                'model' => $model,
                                'attribute' => 'fecha',
                                'language' => 'es',
                                'options' => array(
                                        'showAnim' => 'fold',
                                        'dateFormat' => 'yy-mm-dd',
										'defaultDate' => $model->fecha,
                                        'changeYear' => true,
                                        'changeMonth' => true,
                                        'yearRange' => '2001',
                                ),
                ));?>



		<?php echo $form->error($model,'fecha');
                
                ?>
	</div>
        <div class="row">
		<?php echo $form->hiddenField($model,'usuario',array('value'=>Yii::app()->user->id)); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'detalle'); ?>
		<?php echo $form->textArea($model,'detalle',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'detalle'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
