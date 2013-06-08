<?php
$this->breadcrumbs=array(
	'Condiciones Ivas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CondicionesIva', 'url'=>array('index')),
	array('label'=>'Create CondicionesIva', 'url'=>array('create')),
	array('label'=>'Update CondicionesIva', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CondicionesIva', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CondicionesIva', 'url'=>array('admin')),
);
?>

<h1>View CondicionesIva #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
	),
)); ?>
