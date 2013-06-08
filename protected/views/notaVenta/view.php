<?php
$this->breadcrumbs=array(
	'Nota Ventas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List NotaVenta', 'url'=>array('index')),
	array('label'=>'Create NotaVenta', 'url'=>array('create')),
	array('label'=>'Update NotaVenta', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete NotaVenta', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage NotaVenta', 'url'=>array('admin')),
);
?>

<h1>View NotaVenta #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fecha',
		'detalle',
		'fechaVencimiento',
		'clienteId',
		'periodo',
		'estado',
		'userStamp',
		'timeStamp',
	),
)); ?>
