<?php
$this->breadcrumbs=array(
	'Cta Cte Clientes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CtaCteClientes', 'url'=>array('index')),
	array('label'=>'Create CtaCteClientes', 'url'=>array('create')),
	array('label'=>'Update CtaCteClientes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CtaCteClientes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CtaCteClientes', 'url'=>array('admin')),
);
?>

<h1>View CtaCteClientes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'tipoMov',
		'conceptoId',
		'descripcion',
		'periodo',
		'monto',
		'clienteId',
		'fecha',
		'estado',
		'comprobante',
		'userStamp',
		'timeStamp',
	),
)); ?>
