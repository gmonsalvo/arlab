<?php
$this->breadcrumbs=array(
	'Rendiciones'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Rendiciones', 'url'=>array('index')),
	array('label'=>'Create Rendiciones', 'url'=>array('create')),
	array('label'=>'Update Rendiciones', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Rendiciones', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Rendiciones', 'url'=>array('admin')),
);
?>

<h1>View Rendiciones #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fecha',
		'periodoInicio',
		'periodoFin',
		'cobradorId',
		'estado',
		'userStamp',
		'timeStamp',
	),
)); ?>
