<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cta-cte-clientes-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son requeridos.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha'); ?>
	 <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    // you must specify name or model/attribute
                    'model' => $model,
                    'attribute' => 'fecha',
                    'value' => $model->fecha,
                    'language' => 'es',
                    'options' => array(
                        // how to change the input format? see http://docs.jquery.com/UI/Datepicker/formatDate
                        'dateFormat' => 'yy-mm-dd',
                        'defaultDate' => $model->fecha,
                        'monthNames' => array('Enero,Febrero,Marzo,Abril,Mayo,Junio,Julio,Agosto,Septiembre,Octubre,Noviembre,Diciembre'),
                        'monthNamesShort' => array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"),
                        'dayNames' => array('Domingo,Lunes,Martes,Miercoles,Jueves,Viernes,Sabado'),
                        'dayNamesMin' => array('Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'),
                        'changeMonth' => 'true',
                        'changeYear' => 'true',
                        // shows the button panel under the calendar (buttons like "today" and "done")
                        'showButtonPanel' => 'true',
                        // this is useful to allow only valid chars in the input field, according to dateFormat
                        'constrainInput' => 'false',
                        // speed at which the datepicker appears, time in ms or "slow", "normal" or "fast"
                        'duration' => 'fast',
                        // animation effect, see http://docs.jquery.com/UI/Effects
                        'showAnim' => 'fold',
                    ),
                    // optional: html options will affect the input element, not the datepicker widget itself
                    'htmlOptions' => array(
                        'readonly' => "readonly",
                        'value'=>Date('Y-m-d'),
                        'style' => 'height:20px;',
                        'onChange' => 'js:$("#TmpCheques_fechaPago").focus()',
                    )
                ));
                ?>

		<?php echo $form->error($model,'fecha'); ?>
	</div>
	
	<div class="row">
		<?php 
		 echo $form->hiddenField($model,'tipoMov',array('value'=>'1')); 
		 ?>
	</div>
		
	<div class="row">
		<?php 
		 echo $form->hiddenField($model,'conceptoId',array('value'=>'16')); 
		?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'Pendientes'); ?>
		<?php 
                //armamos el criterio de busqueda
                $criterio = new CDbCriteria;
                $criterio->condition='clienteId=:clienteId AND estado=:estado';
                $criterio->params=array(':clienteId'=>$_GET['clienteId'], ':estado'=>'0');
                $criterio->order="periodo,id";
                
                echo $form->dropDownList($model,'notaVentaId', CHtml::listData(NotaVenta::model()->findAll($criterio), 'id', 'detalleCompleto'), array('prompt' => 'Seleccione')); 
                
                ?>
		<?php echo $form->error($model,'notaVentaId'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'monto'); ?>
		<?php echo $form->textField($model,'monto',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'monto'); ?>
	</div>

	
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
            <?php echo CHtml::Button('Cancelar',array('submit'=>array('admin', 'clienteId'=>$_GET['clienteId']))); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->