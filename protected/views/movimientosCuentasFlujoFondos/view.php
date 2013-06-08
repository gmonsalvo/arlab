<?php
$this->breadcrumbs=array(
	'Movimientos Stocks'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MovimientosStock', 'url'=>array('index')),
	array('label'=>'Create MovimientosStock', 'url'=>array('create')),
	array('label'=>'Update MovimientosStock', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MovimientosStock', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MovimientosStock', 'url'=>array('admin')),
);
?>

<h1>View MovimientosStock #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'depositoId',
		'equipoId',
		'tipoMov',
		'cantidad',
		'observaciones',
		'userStamp',
		'timeStamp',
	),
)); ?>
