<?php
if (isset($_GET['FlujoFondos']['periodo'])) {
	$model->periodo=$_GET['FlujoFondos']['periodo'];
}



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('flujo-fondos-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="search-form">
<?php $this->renderPartial('_searchReporte',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<h3>Detalle</h3>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'flujo-fondos-grid',
	'ajaxUpdate'=>'false',
	//'filter'=>$model,
	'dataProvider'=>$model->searchReporte(),
	'columns'=>array(
		'id',
		'fecha',
		'monto',
     	array(        
		      'name'=>'conceptoId',
		      'header'=>'Concepto',
		      'value'=>'$data->concepto->nombre',
		   ),
     	array(        
		      'name'=>'tipoFondoId',
		      'header'=>'TipoFondo',
		      'value'=>'$data->tipoFondo->nombre',
		   ),

		'descripcion',
	),
));
//Mostramos el  saldo de fondos para el periodos
 ?>

<h3>Total : $ <?php //echo number_format($model->getTotal(),2);?></h3>