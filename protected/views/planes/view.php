<?php
$this->breadcrumbs=array(
	'Planes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Planes', 'url'=>array('index')),
	array('label'=>'Create Planes', 'url'=>array('create')),
	array('label'=>'Update Planes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Planes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Planes', 'url'=>array('admin')),
);
?>

<h1>View Planes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'descripcion',
		'subida',
		'bajada',
		'costo',
	),
)); ?>
