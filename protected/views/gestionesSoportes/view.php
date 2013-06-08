<?php
$this->breadcrumbs=array(
	'Gestiones Soportes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List GestionesSoportes', 'url'=>array('index')),
	array('label'=>'Create GestionesSoportes', 'url'=>array('create')),
	array('label'=>'Update GestionesSoportes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete GestionesSoportes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GestionesSoportes', 'url'=>array('admin')),
);
?>

<h1>View GestionesSoportes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'soporteId',
		'fecha',
		'detalle',
		'usuario',
	),
)); ?>
