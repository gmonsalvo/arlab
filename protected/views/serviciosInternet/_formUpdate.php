<script>
function obtenerPrecioPlan(){
     var id=$("#ServiciosInternet_planId").val()
	 
    //si hay alguno seleccionado
    if(id){
        $.ajax({
            type: 'POST',
            url: "<?php echo CController::createUrl('planes/getPrecio') ?>",
            data:{'id':id},
            dataType: 'Text',
            success:function(data){
                eval(data);
            }
        });
    }
    else
    {
        $('#tasaCambio').val("0.00");
    }
}
</script>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'servicios-internet-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_instalacion'); ?>
	
		<?php 
		echo $form->hiddenField($model,'clienteId'); 
		
		?>
	
	
<?php
		$this->widget('zii.widgets.jui.CJuiDatePicker',
			array(
				// you must specify name or model/attribute
				'model'=>$model,
				'attribute'=>'fecha_instalacion',
				'language' => 'es',
				'options' => array(
					'dateFormat'=>'yy-m-d',
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
				//'value'=>Date('Y-m-d'),
				'readonly'=>"readonly",
				'style'=>'height:20px;'
				)
			)
		);?>
		<?php echo $form->error($model,'fecha_instalacion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'domicilio'); ?>
		<?php echo $form->textField($model,'domicilio',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'domicilio'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ciudadId'); ?>
		<?php echo $form->dropDownList($model,'ciudadId', CHtml::listData(Ciudades::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'), array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'ciudadId'); ?>
	</div>

   	<div class="row">
		<?php echo $form->labelEx($model,'barrioId'); ?>
		<?php echo $form->dropDownList($model,'barrioId', CHtml::listData(Barrios::model()->findAll(array('order'=>'nombre')), 'id', 'nombre'), array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'barrioId'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'telefono'); ?>
		<?php echo $form->textField($model,'telefono',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'telefono'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'servidorId'); ?>
		<?php echo $form->dropDownList($model,'servidorId', CHtml::listData(Nodos::model()->findAll(array('condition'=>'tipo=1 or tipo=2','order'=>'nombre')), 'id', 'gatewayDescripcion'), array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'servidorID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'repetidorId'); ?>
		<?php echo $form->dropDownList($model,'repetidorId', CHtml::listData(Nodos::model()->findAll(array('condition'=>'tipo=0 or tipo=2','order'=>'ssid')), 'id', 'repetidorDescripcion'), array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'repetidorId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Nivel de Señal'); ?>
		<?php echo $form->textField($model,'nivel_senal',array('size'=>5,'maxlength'=>3)); ?>
		<?php echo $form->error($model,'nivel_senal'); ?>
	</div>
<div class="row">
		<?php echo $form->labelEx($model,'Tipo Configuracion Antena'); ?>
		<?php echo $form->dropDownList($model,'tipoConfiguracionAntena',array('0' => 'Router', '1' => 'Bridge')); ?>
		<?php echo $form->error($model,'tipoConfiguracionAntena'); ?>
	</div>
	

	<div class="row">
		<?php echo $form->labelEx($model,'IP LAN'); ?>
		<?php echo $form->textField($model,'ip_lan',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'ip_lan'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'IP Antena'); ?>
		<?php echo $form->textField($model,'ip_antena',array('size'=>15,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'ip_antena'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'equipoId'); ?>
		<?php echo $form->dropDownList($model,'equipoId', CHtml::listData(Equipos::model()->findAll(), 'id', 'descripcion'), array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'equipoId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cicloId'); ?>
		<?php echo $form->dropDownList($model,'cicloId', CHtml::listData(Ciclos::model()->findAll(), 'id', 'descripcion')); ?>
		<?php echo $form->error($model,'cicloId'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'planId'); ?>
		<?php echo $form->dropDownList($model,'planId', CHtml::listData(Planes::model()->findAll(), 'id', 'descripcion'), array('prompt' => 'Seleccione',"disabled"=>"disabled" )); ?>
		<?php echo $form->error($model,'planId'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'costoServicio')."$";?>
		<?php echo $form->textField($model,'costoServicio',array('size'=>15,'maxlength'=>15,"disabled"=>"disabled" )); ?>
		<?php echo $form->error($model,'costoServicio'); ?>
	</div>
       <div class="row">
		<?php echo $form->labelEx($model,'instaladoresId'); ?>
		<?php echo $form->dropDownList($model,'instaladoresId', CHtml::listData(Instaladores::model()->findAll(), 'id', 'descripcion'), array('prompt' => 'Seleccione')); ?>
		<?php echo $form->error($model,'instaladoresId'); ?>
	</div>

	

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Guardar' : 'Guardar Cambios'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->


