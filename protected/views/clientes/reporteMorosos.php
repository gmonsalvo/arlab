<h1>Clientes Morosos</h1>
<div class="row">
    <?php echo CHtml::label("Fecha Vencimiento:", "NotaVenta_fechaVencimiento");?>
            <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            // you must specify name or model/attribute
            'model' => $notaVenta,
            'attribute' => 'fechaVencimiento',
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
                'value' => Date("d/m/Y"),
                'readonly' => "readonly",
                'style' => 'height:20px;',
                'onChange' => 'js:$("#NotaVenta_fechaVencimiento").focus()',
            )
                )
        );
        ?> 
</div>
<div class="row">
<?php echo CHtml::label("Periodos Adeudados",'periodosAdeudados');?>    
<?php echo CHtml::textField('periodosAdeudados', 5, array('id'=>'periodosAdeudados'));?>
</div>    
<?php

echo CHtml::ajaxButton('Filtrar',
    CHtml::normalizeUrl(array('clientes/getReporteMorosos', 'render' => false)), 
        array(
            'type' => 'GET',
            'data' => array(
                'fechaVencimiento' => 'js:$("#NotaVenta_fechaVencimiento").val()',
                'periodosAdeudados' => 'js:$("#periodosAdeudados").val()'
            ),
        'dataType' => 'text',
        'success' => 'js:function(data){
			$("#reporte").html(data);
		      }',
        )
    );
?>

<div id="reporte">
    <?php $this->actionGetReporteMorosos();?>
</div>