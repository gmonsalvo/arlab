<?php
$this->breadcrumbs=array(
	'Empleadoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Empleados', 'url'=>array('index')),
	array('label'=>'Create Empleados', 'url'=>array('create')),
	array('label'=>'Update Empleados', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Empleados', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Empleados', 'url'=>array('admin')),
);
?>

<h1>View Empleados #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombreApellido',
		'fechaAlta',
		'sueldoActual',
		'montoPrestamo',
		'userStamp',
		'timeStamp',
	),
)); ?>
