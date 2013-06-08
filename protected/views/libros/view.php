<?php
$this->breadcrumbs=array(
	'Libroses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Libros', 'url'=>array('index')),
	array('label'=>'Create Libros', 'url'=>array('create')),
	array('label'=>'Update Libros', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Libros', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Libros', 'url'=>array('admin')),
);
?>

<h1>View Libros #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
		'tipoLibroId',
	),
)); ?>
