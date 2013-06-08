<style>
    #grid{
        position:relative;
        overflow: auto;
        height: 400px;
    }
</style>
<?php
$this->menu=array(

	array('label'=>'Nueva Rendicion', 'url'=>array('create')),
);

?>
<script>
function recalcularTotal(){
	var montos = $("input[name^=montoPagado]");
	var total = 0;
	$.each(montos,function(index,monto){
		total += parseFloat(monto.value);
	});
	var comision = (total * parseFloat($("#porcentaje").val()))/100;
	var subtotal = total - comision;
	$("#subtotal").val(subtotal.toFixed(2));
	$("#comision").val(comision.toFixed(2));
	$("#total").val(total.toFixed(2));
}
</script>
<h1>Listado de Recibos</h1>
<?php
$this->beginWidget('zii.widgets.CPortlet', array(
    'title' => 'Rendicion',
));
echo "<b>Rendicion #" . $model->id . "</b><br>";
echo "<b>Cobrador :</b> " . $model->cobrador->descripcion . "<br>";

$this->endWidget();
?>
<?php $rendicionesRecibo = new RendicionesRecibos();
	$rendicionesRecibo->rendicionId = $model->id;
?>
<?php
	$form = $this->beginWidget('CActiveForm', array(
		'id' => 'rendiciones-form',
        'enableAjaxValidation' => false,
    ));
?>
<div id="grid">
	<?php
	set_time_limit(60);
	$this->widget('zii.widgets.grid.CGridView', array(
		'id'=>'rendiciones-grid',
		'dataProvider'=>$rendicionesRecibo->search(false),
		'columns'=>array(
			array(
			      'name'=>'reciboId',
			      'header'=>'Nro Recibo',
			      'value'=>'$data->recibo->numero',
			   ),
			array(
			      'name'=>'reciboId',
			      'header'=>'Cliente',
			      'value'=>'$data->recibo->cliente->razonSocial',
			),
			array(
			      'name'=>'reciboId',
			      'header'=>'Monto Pagado',
			      'type'=>'raw',
			      'value'=>'CHtml::textField("montoPagado[$data->reciboId]",$data->recibo->totalFormaPago,array("onblur"=>"recalcularTotal()"))',
			),
		)
	));
	?>
</div>
<div class="row">
<?php

$subtotal = $model->totalPagado;
$porcentaje = $model->cobrador->porcentaje;
$comision = ($subtotal * $porcentaje)/100;
$total = $subtotal - $comision;

echo CHtml::label("Subtotal","subtotal");
echo CHtml::textField("subtotal",$subtotal,array("id"=>"subtotal","readonly"=>"readonly"));
?>
</div>
<div class="row">
<?php
echo CHtml::label("Comision","comision");
echo CHtml::textField("comision",$comision,array("id"=>"comision","readonly"=>"readonly"));
echo CHtml::hiddenField("porcentaje",$porcentaje,array("id"=>"porcentaje"));
?>
</div>
<div class="row">
<?php
echo CHtml::label("Total","total");
echo CHtml::textField("total",$total,array("id"=>"total","readonly"=>"readonly"));
?>
</div>
<div class="row buttons">
   <?php echo CHtml::button("Procesar",array('title'=>"Procesar",'onclick'=>'js:$("#rendiciones-form").submit()')); ?>
</div>
<?php $this->endWidget("rendiciones-form"); ?>