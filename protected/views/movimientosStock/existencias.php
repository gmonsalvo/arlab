
<h1>Existencias de Stock</h1>
<br>

<?php
// retrieve the models from db
$models = Depositos::model()->findAll(
                 array('order' => 'descripcion'));
 
// format models as $key=>$value with listData
$list = CHtml::listData($models, 
                'id', 'descripcion');
echo CHtml::dropDownList('depositos', '0', 
              $list,
              array('empty' => '(Seleccione un Deposito)'));
?>

<?php
echo CHtml::ajaxButton('Filtrar', CHtml::normalizeUrl(array('movimientosStock/detalleExistencias', 'render' => false)), array(
    'type' => 'GET',
    'data' => array(
        'depositoId' => 'js:$("#depositos").val()',
        
    ),
    'dataType' => 'text',
    'success' => 'js:function(data){
					$("#gridDetalleExistencias").html(data);
					}',
))
?>
<br>
<div id="gridDetalleExistencias">

</div>