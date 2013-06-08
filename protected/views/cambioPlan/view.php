<?php
$this->breadcrumbs=array(
	'Cambio Plans'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CambioPlan', 'url'=>array('index')),
	array('label'=>'Create CambioPlan', 'url'=>array('create')),
	array('label'=>'Update CambioPlan', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CambioPlan', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CambioPlan', 'url'=>array('admin')),
);
?>

<h1>View CambioPlan #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'servicioInternetId',
		'fecha',
		'accion',
		'observaciones',
		'planId',
		'costoServicio',
		'userStamp',
		'timeStamp',
	),
)); ?>
