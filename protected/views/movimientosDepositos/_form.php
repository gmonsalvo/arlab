<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'movimientos-stock-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>

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
					'dateFormat'=>'yy-mm-dd',
					//'defaultDate'=>Date('dd-m-Y'),
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
				//'value'=>Date('Y-m-d'),
				'readonly'=>"readonly",
				'style'=>'height:20px;'
				)
			)
		);?>
	<?php echo $form->error($model,'fecha'); ?>
       	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'equipoId'); ?>
		<?php echo $form->dropDownList($model,'equipoId', CHtml::listData(Equipos::model()->findAll(array('order'=>'descripcion')), 'id', 'descripcion'), array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'equipoId'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'cantidad'); ?>
		<?php echo $form->textField($model,'cantidad',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'cantidad'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'depositoOrigen'); ?>
		<?php echo $form->dropDownList($model,'depositoOrigen', CHtml::listData(Depositos::model()->findAll(array('order'=>'descripcion')), 'id', 'descripcion'), array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'depositoOrigen'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'depositoDestino'); ?>
		<?php echo $form->dropDownList($model,'depositoDestino', CHtml::listData(Depositos::model()->findAll(array('order'=>'descripcion')), 'id', 'descripcion'), array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'depositoDestino'); ?>
	</div>
	

	<div class="row">
		<?php echo $form->labelEx($model,'observaciones'); ?>
		<?php echo $form->textField($model,'observaciones',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'observaciones'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Realizar Movimiento'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->