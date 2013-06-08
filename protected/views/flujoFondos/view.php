<?php
$this->breadcrumbs=array(
	'Flujo Fondoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List FlujoFondos', 'url'=>array('index')),
	array('label'=>'Create FlujoFondos', 'url'=>array('create')),
	array('label'=>'Update FlujoFondos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete FlujoFondos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FlujoFondos', 'url'=>array('admin')),
);
?>

<h1>View FlujoFondos #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fecha',
		'cuentaId',
		'tipoMov',
		'monto',
		'conceptoId',
		'tipoFondoId',
		'descripcion',
		'monedaId',
		'userStamp',
		'timeStamp',
	),
)); ?>
