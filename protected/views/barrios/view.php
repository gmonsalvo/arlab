<?php
$this->breadcrumbs=array(
	'Barrioses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Barrios', 'url'=>array('index')),
	array('label'=>'Create Barrios', 'url'=>array('create')),
	array('label'=>'Update Barrios', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Barrios', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Barrios', 'url'=>array('admin')),
);
?>

<h1>View Barrios #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'ciudadId',
	),
)); ?>
