<?php
$this->breadcrumbs=array(
	'Reportes Dinero Mails'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ReportesDineroMail', 'url'=>array('index')),
	array('label'=>'Create ReportesDineroMail', 'url'=>array('create')),
	array('label'=>'View ReportesDineroMail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ReportesDineroMail', 'url'=>array('admin')),
);
?>

<h1>Update ReportesDineroMail <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>