<?php
$this->breadcrumbs=array(
	'Arqueos Fondoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ArqueosFondos', 'url'=>array('index')),
	array('label'=>'Create ArqueosFondos', 'url'=>array('create')),
	array('label'=>'Update ArqueosFondos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ArqueosFondos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ArqueosFondos', 'url'=>array('admin')),
);
?>

<h1>View ArqueosFondos #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'arqueoId',
		'tipoFondoId',
		'saldo',
		'valorActual',
	),
)); ?>
