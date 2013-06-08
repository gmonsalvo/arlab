<?php
$this->breadcrumbs=array(
	'Tipo Gestiones'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TipoGestiones', 'url'=>array('index')),
	array('label'=>'Create TipoGestiones', 'url'=>array('create')),
	array('label'=>'Update TipoGestiones', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TipoGestiones', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TipoGestiones', 'url'=>array('admin')),
);
?>

<h1>View TipoGestiones #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
	),
)); ?>
