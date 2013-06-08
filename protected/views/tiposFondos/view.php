<?php
$this->breadcrumbs=array(
	'Tipos Fondoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TiposFondos', 'url'=>array('index')),
	array('label'=>'Create TiposFondos', 'url'=>array('create')),
	array('label'=>'Update TiposFondos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TiposFondos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TiposFondos', 'url'=>array('admin')),
);
?>

<h1>View TiposFondos #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'userStamp',
		'timeStamp',
	),
)); ?>
