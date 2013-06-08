<?php
$this->breadcrumbs=array(
	'Tipo Libroses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TipoLibros', 'url'=>array('index')),
	array('label'=>'Create TipoLibros', 'url'=>array('create')),
	array('label'=>'Update TipoLibros', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TipoLibros', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TipoLibros', 'url'=>array('admin')),
);
?>

<h1>View TipoLibros #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
	),
)); ?>
