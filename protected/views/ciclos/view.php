<?php
$this->breadcrumbs=array(
	'Cicloses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Ciclos', 'url'=>array('index')),
	array('label'=>'Create Ciclos', 'url'=>array('create')),
	array('label'=>'Update Ciclos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Ciclos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Ciclos', 'url'=>array('admin')),
);
?>

<h1>View Ciclos #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'descripcion',
	),
)); ?>
