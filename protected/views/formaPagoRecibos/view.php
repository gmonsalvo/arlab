<?php
$this->breadcrumbs=array(
	'Forma Pago Reciboses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List FormaPagoRecibos', 'url'=>array('index')),
	array('label'=>'Create FormaPagoRecibos', 'url'=>array('create')),
	array('label'=>'Update FormaPagoRecibos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete FormaPagoRecibos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage FormaPagoRecibos', 'url'=>array('admin')),
);
?>

<h1>View FormaPagoRecibos #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'reciboId',
		'fecha',
		'tipoFormaPago',
		'numeroReferencia',
		'monto',
	),
)); ?>
