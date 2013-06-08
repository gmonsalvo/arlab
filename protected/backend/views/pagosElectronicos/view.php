<?php
$this->breadcrumbs=array(
	'Pagos Electronicoses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PagosElectronicos', 'url'=>array('index')),
	array('label'=>'Create PagosElectronicos', 'url'=>array('create')),
	array('label'=>'Update PagosElectronicos', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PagosElectronicos', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PagosElectronicos', 'url'=>array('admin')),
);
?>

<h1>View PagosElectronicos #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fecha',
		'clienteId',
		'procesadorPago',
		'monto',
		'estado',
		'userStamp',
		'timeStamp',
		'fechaAcreditacion',
	),
)); ?>
