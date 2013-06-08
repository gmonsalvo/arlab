<?php
$this->breadcrumbs=array(
	'Nodoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Nodos', 'url'=>array('index')),
	array('label'=>'Create Nodos', 'url'=>array('create')),
	array('label'=>'Update Nodos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Nodos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Nodos', 'url'=>array('admin')),
);
?>

<h1>View Nodos #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'ip_wan',
		'ssid',
		'frequencia',
		'ip_lan',
		'tipo',
	),
)); ?>
