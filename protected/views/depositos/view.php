<?php
$this->breadcrumbs=array(
	'Depositoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Depositos', 'url'=>array('index')),
	array('label'=>'Create Depositos', 'url'=>array('create')),
	array('label'=>'Update Depositos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Depositos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Depositos', 'url'=>array('admin')),
);
?>

<h1>View Depositos #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'descripcion',
		'userStamp',
		'timeStamp',
	),
)); ?>
