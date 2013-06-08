<?php
$this->breadcrumbs=array(
	'Reportes Dinero Mails'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ReportesDineroMail', 'url'=>array('index')),
	array('label'=>'Create ReportesDineroMail', 'url'=>array('create')),
	array('label'=>'Update ReportesDineroMail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ReportesDineroMail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ReportesDineroMail', 'url'=>array('admin')),
);
?>

<h1>View ReportesDineroMail #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fechaInicio',
		'fechaFin',
		'estado',
		'userStamp',
		'timeStamp',
	),
)); ?>
