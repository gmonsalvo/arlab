<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'gestiones-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); 
      
        ?>
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
				'value'=>Date('Y-m-d'),
				'readonly'=>"readonly",
				'style'=>'height:20px;'
				)
			)
		);?>
		<?php echo $form->error($model,'fecha'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'detalle'); ?>
		<?php echo $form->textArea($model, 'detalle', array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'detalle'); ?>
	</div>
        <?php 
        echo $form->hiddenField($model,'clienteId',array('value'=>$_GET['clienteId'])); 
        echo $form->hiddenField($model,'gestionPadreId',array('value'=>$_GET['gestionPadreId'])); 
        echo $form->hiddenField($model,'temaId',array('value'=>$_GET['temaId'])); 
        ?>
	<div class="row">
		<?php echo $form->labelEx($model,'usuarioResponsable'); ?>
		<?php echo $form->dropDownList($model,'usuarioResponsable', CHtml::listData(User::model()->findAll(), 'id', 'username'),array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'usuarioResponsable'); ?>
	</div>

	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Cerrar'); ?>
                <?php echo CHtml::Button('Cancelar',array('submit'=>array('view', 'id'=>$_GET['gestionPadreId']))); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->