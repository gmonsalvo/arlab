<?php
$this->breadcrumbs=array(
	'Conceptoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Conceptos', 'url'=>array('index')),
	array('label'=>'Create Conceptos', 'url'=>array('create')),
	array('label'=>'Update Conceptos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Conceptos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Conceptos', 'url'=>array('admin')),
);
?>

<h1>View Conceptos #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'tipoConcepto',
	),
)); ?>
