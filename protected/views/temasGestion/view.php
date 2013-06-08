<?php
$this->breadcrumbs=array(
	'Temas Gestions'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Nuevo Tema de Gestion', 'url'=>array('create')),
	array('label'=>'Listar Temas de Gestion', 'url'=>array('admin')),
);
?>

<h1>Viendo Tema de Gestion #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'tipoGestionId',
		'descripcion',
		'userStamp',
		'timeStamp',
	),
)); ?>
