<h1>Servicio VOIP #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'fechaInstalacion',
        'domicilio',
        array(
            'label' => 'Ciudad',
            'value' => $model->ciudad->nombre,
        ),
        'minutosLibres',
        'detalleEquipo',
        'instaladores',
        'costoServicio',
    )
));
?>
<br>
<h1>Detalle de Llamadas:</h1>
<br>

<?php
echo CHtml::dropDownList("periodo", "0", array('201211' => '201211', '201212' => '201212', '201301' => '201301', '201302' => '201302', '201303' => '201303', '201304' => '201304', '201305' => '201305', '201306' => '201306', '201307' => '201307', '201308' => '201308', '201309' => '201309', '201310' => '201310'), array(
    'prompt' => 'Seleccione un Periodo',
));
?>

<?php
echo CHtml::ajaxButton('Filtrar', CHtml::normalizeUrl(array('serviciosVoip/detalleConsumos', 'render' => false)), array(
    'type' => 'GET',
    'data' => array(
        'periodo' => 'js:$("#periodo").val()',
        'id' => $model->id
    ),
    'dataType' => 'text',
    'success' => 'js:function(data){
					$("#gridDetalleLlamadas").html(data);
					}',
))
?>



<div id="gridDetalleLlamadas">

</div>