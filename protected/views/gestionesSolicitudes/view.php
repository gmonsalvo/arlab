<?php
$this->breadcrumbs=array(
	'Gestiones Solicitudes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List GestionesSolicitudes', 'url'=>array('index')),
	array('label'=>'Create GestionesSolicitudes', 'url'=>array('create')),
	array('label'=>'Update GestionesSolicitudes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete GestionesSolicitudes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GestionesSolicitudes', 'url'=>array('admin')),
);
?>

<h1>View GestionesSolicitudes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'solicitudId',
		'fecha',
		'gestion',
		'usuario',
	),
)); ?>
