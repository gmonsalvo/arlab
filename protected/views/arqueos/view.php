<?php
$this->breadcrumbs=array(
	'Arqueoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Arqueos', 'url'=>array('index')),
	array('label'=>'Create Arqueos', 'url'=>array('create')),
	array('label'=>'Update Arqueos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Arqueos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Arqueos', 'url'=>array('admin')),
);
?>

<h1>View Arqueos #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'cuentaId',
		'saldoTotal',
		'valorActualTotal',
		'userStamp',
		'timeStamp',
	),
)); ?>
