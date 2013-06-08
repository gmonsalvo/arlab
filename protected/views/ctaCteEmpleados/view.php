<?php
$this->breadcrumbs=array(
	'Cta Cte Empleadoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CtaCteEmpleados', 'url'=>array('index')),
	array('label'=>'Create CtaCteEmpleados', 'url'=>array('create')),
	array('label'=>'Update CtaCteEmpleados', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CtaCteEmpleados', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CtaCteEmpleados', 'url'=>array('admin')),
);
?>

<h1>View CtaCteEmpleados #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fecha',
		'tipoMov',
		'empleadoId',
		'conceptoId',
		'periodo',
		'monto',
		'descripcion',
		'userStamp',
		'timeStamp',
	),
)); ?>
