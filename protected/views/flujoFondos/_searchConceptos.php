<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
));
?>
<table>
<tr>    
<td class="row">
		<?php echo $form->label($model,'conceptoId'); ?>
<?php echo CHtml::activeDropDownList($model,'conceptoId',
		CHtml::listData(ConceptosFlujoFondos::model()->findAll(), 
		'id', 'nombre'),array('empty'=>'Seleccione un Conceptos'));
	?>
</td>
<td class="row">
	<?php echo $form->label($model,'Fecha Inicio'); ?>
    <?php
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        // you must specify name or model/attribute
        'name' => 'fechaInicio',
         'model' => $model,
        'attribute' => 'fechaInicio',
        'language' => 'es',
        'options' => array(
            'dateFormat' => 'dd/mm/yy',
            //'defaultDate'=>Date('d-m-Y'),
            'changeMonth' => 'true',
            'changeYear' => 'true',
            'showButtonPanel' => 'true',
            'constrainInput' => 'false',
            'duration' => 'fast',
            'showAnim' => 'fold',
        ),
        'htmlOptions' => array(
            'id' => 'fechaInicio',
            'value' => '01/02/2013',
            'readonly' => "readonly",
            'style' => 'height:20px;'
        )
            )
    );
    ?>
</td>	

<td class="row">
<?php echo $form->label($model,'Fecha Fin'); ?>
    <?php
    $fechaFin=Date('d/m/Y');
    $this->widget('zii.widgets.jui.CJuiDatePicker', array(
        // you must specify name or model/attribute
        'name' => 'fechaFin',
        'model' => $model,
        'attribute' => 'fechaFin',
        'language' => 'es',
        'options' => array(
            'dateFormat' => 'dd/mm/yy',
            //'defaultDate'=>Date('d-m-Y'),
            'changeMonth' => 'true',
            'changeYear' => 'true',
            'showButtonPanel' => 'true',
            'constrainInput' => 'false',
            'duration' => 'fast',
            'showAnim' => 'fold',
        ),
        'htmlOptions' => array(
            'id' => 'fechaFin',
            'readonly' => "readonly",
            'style' => 'height:20px;',
            'value' => $fechaFin
        )
            )
    );
    ?>
 </td>	
<td class="row">
		<?php echo CHtml::submitButton('Filtrar'); ?>
</td>
<tr></table>
<?php $this->endWidget(); 
?>

</div><!-- search-form -->