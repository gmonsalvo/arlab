<?php
$this->breadcrumbs=array(
	'Facturases'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Facturas', 'url'=>array('index')),
	array('label'=>'Create Facturas', 'url'=>array('create')),
	array('label'=>'Update Facturas', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Facturas', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Facturas', 'url'=>array('admin')),
);
?>

<h1>View Facturas #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'numero',
		'puntoVenta',
		'tipoFactura',
		'fecha',
		'clienteId',
		'recargo',
		'descuento',
		'montoTotal',
		'userStamp',
		'timeStamp',
	),
)); ?>
