<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cta-cte-clientes-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

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
                        'dateFormat' => 'yy-m-d',
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
                        'style' => 'height:20px;',
                        'onChange' => 'js:$("#TmpCheques_fechaPago").focus()',
                    )
                ));
                ?>

		<?php echo $form->error($model,'fecha'); ?>
	</div>
	
	
	<div class="row">
	<?php
	echo $form->labelEx($model, 'clienteId');
	$this->widget('EJuiAutoCompleteFkField', array(
		  'model'=>$model, 
		  'attribute'=>'clienteId', //the FK field (from CJuiInputWidget)
		  // controller method to return the autoComplete data (from CJuiAutoComplete)
		  'sourceUrl'=>Yii::app()->createUrl('/clientes/buscarRazonSocial'), 
		  // defaults to false.  set 'true' to display the FK field with 'readonly' attribute.
		  'showFKField'=>true,
		   // display size of the FK field.  only matters if not hidden.  defaults to 10
		  'FKFieldSize'=>15, 
		  'relName'=>'cliente', // the relation name defined above
		  'displayAttr'=>'razonSocial',  // attribute or pseudo-attribute to display
		  // length of the AutoComplete/display field, defaults to 50
		  'autoCompleteLength'=>40,
		  // any attributes of CJuiAutoComplete and jQuery JUI AutoComplete widget may 
		  // also be defined.  read the code and docs for all options
		  'options'=>array(
			  // number of characters that must be typed before 
			  // autoCompleter returns a value, defaults to 2
			  'minLength'=>1, 
		  ),
	 ));
	 echo $form->error($model, 'clienteId');
	?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'tipoMov'); ?>
        <?php echo $form->dropDownList($model, 'tipoMov', $model->getTypeOptions(), array('prompt' => 'Seleccione un Tipo de Mov.')); ?></td>
		<?php echo $form->error($model,'tipoMov'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'conceptoId'); ?>
		<?php echo $form->dropDownList($model,'conceptoId', CHtml::listData(Conceptos::model()->findAll(), 'id', 'nombre'), array('prompt' => 'Seleccione un Concepto')); ?>
		<?php echo $form->error($model,'conceptoId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'periodo'); ?>
		<?php echo $form->textField($model,'periodo'); ?>
		<?php echo $form->error($model,'periodo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'monto'); ?>
		<?php echo $form->textField($model,'monto',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'monto'); ?>
	</div>

	
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->