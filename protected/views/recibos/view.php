<?php
$this->breadcrumbs=array(
	'Reciboses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Recibos', 'url'=>array('index')),
	array('label'=>'Create Recibos', 'url'=>array('create')),
	array('label'=>'Update Recibos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Recibos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Recibos', 'url'=>array('admin')),
);
?>

<h1>View Recibos #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'sucursal',
		'numero',
		'fecha',
		'clienteId',
		'detalle',
		'montoTotal',
		'userStamp',
		'timeStamp',
	),
)); ?>
