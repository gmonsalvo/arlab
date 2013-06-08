<?php
$this->breadcrumbs=array(
	'Recibos Nota Ventas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List RecibosNotaVenta', 'url'=>array('index')),
	array('label'=>'Create RecibosNotaVenta', 'url'=>array('create')),
	array('label'=>'Update RecibosNotaVenta', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete RecibosNotaVenta', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RecibosNotaVenta', 'url'=>array('admin')),
);
?>

<h1>View RecibosNotaVenta #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'reciboId',
		'notaVentaId',
		'monto',
	),
)); ?>
