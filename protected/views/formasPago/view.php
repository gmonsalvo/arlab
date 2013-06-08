<?php
$this->breadcrumbs=array(
	'Formas Pagos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List FormasPago', 'url'=>array('index')),
	array('label'=>'Create FormasPago', 'url'=>array('create')),
	array('label'=>'Update FormasPago', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete FormasPago', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FormasPago', 'url'=>array('admin')),
);
?>

<h1>View FormasPago #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
	),
)); ?>
